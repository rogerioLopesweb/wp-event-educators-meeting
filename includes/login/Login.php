<?php
    class Login
    {
        public static function init(){
            add_shortcode( 'form_login_custom', 'Login::formLogin' );
            add_shortcode( 'force_redirect_login', 'Login::forceRedirectLogin' );
			//add_shortcode( 'force_redirect_dashboard', 'Login::forceRedirectDashboard' );
			add_shortcode( 'force_redirect_logoult', 'Login::forceRedirectLogoult' );
        }
        public static function formLogin(){
            Login::formTemplate();
            Login::auth();
        }
        public static function formTemplate() {
            if(is_user_logged_in() && current_user_can('administrator')) {
              return "[form_login_custom]";
           }
            if ( is_user_logged_in() ) {
               /* echo 'VOCÊ ESTÁ LOGADO, REDIRECIONANDO...';
                if(get_the_ID() != false){
                    $post_id = get_the_ID();
                    $page_slug = get_post_field( 'post_name', $post_id );
                    if($page_slug == 'login'){
                        Login::forceRedirectDashboard();
                        exit;
                    }
                }*/
            } else {
                if(isset($_POST['login-form-username'])){
                    $login = sanitize_user($_POST['login-form-username']);
                    $email = esc_attr($_POST['login-form-email']);
                }else{
                    $login = "";
                    $email = "";
                }
                // 'Vc não esta locado';
                echo '<form id="login-form" action="'.get_site_url(). "/comunidade" .'" class="form-login" method="POST">
	            <div>
	              <label for="login-form-username">Nome:</label>
	              <input type="text" name="login-form-username" id="login-form-username" value="'.$login.'" class="form-btn-username" required />
	            </div>
	            <div>
	              <label for="login-form-email">E-mail:</label>
					<div class="email-container">
					  <input type="email" name="login-form-email" id="login-form-email" value="'.$email.'"  class="form-btn-password" required>
					  <span class="email-toggle-icon"></span>
					</div>
				</div>
	            <div style="display:flex; align-items:center; justify-content:space-between; margin-top:10px;">
					<button type="submit" class="form-btn-submit" id="login-form-submit">ENTRAR</button>
	            </div>
	          </form>';
            }
        }
        public static function auth(){
            if(isset($_POST['login-form-username'])){
                $login = sanitize_user($_POST['login-form-username']);
                $email = esc_attr($_POST['login-form-email']);
                if($login != "" && $email != ""){
                    $login =  str_replace(array('-', '.','/'), '', $login);
                    $dataUserExternal =  Login::loginByBaseUserEmail($email);
                    if($dataUserExternal["status"] == "S"){
                        $password = $dataUserExternal["password"];
                        Login::loginWP($login, $password, $dataUserExternal);
                    }else{
                        echo $dataUserExternal["msg"];
                    }
                }
            }
        }

        public static function loginByBaseUserEmail($email){
            $args = array(
                'post_type' => 'base-usuarios',
                'post_status' => 'publish',
                'posts_per_page' => 1,
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'e-mail',
                        'value' =>  $email,
                        'compare' => '='
                    )
                ),
            );
        
            $result = new WP_Query($args);
             
            $retorno = array("status"=>"F",  "name"=>"", "email"=>"");
            if ($result->have_posts()) {
                while ($result->have_posts()) {
                    $result->the_post();
                    $post_id = get_the_ID();
                    //$nome = get_the_title( $post_id );
                    $nome = get_post_meta($post_id, "nome", true);
                    
                    $retorno =  array("status"=>"S",
                        "msg" =>"<div class='sucesso-login'>LOGIN EFETUADO COM SUCESSO</div>",
                        "name"=>$nome,
                        "email"=>$email,
                        "login" => $email,
                        "password" => "ysD@kk@06515",
                    );
                }
                wp_reset_postdata();
            }else{
                $retorno = array("status"=>"F", "msg" =>"<div class='erro-login'>DADOS INCORRETO(S)</div>");
            }

            /*var_export($retorno);
            exit;*/
           return $retorno;

        }
       

        public static function loginWP($login, $password, $dataUserExternal){
            $credentials = array();
            $credentials['user_login'] = $login;
            $credentials['user_password'] = $password;
            $user = wp_signon($credentials, "");
            if ( is_wp_error($user) ) {
                $credentials['user_password'] = $login ."@Tmp";
                $user = wp_signon($credentials, "");
            }
            if ( is_wp_error($user) ) {
                Login::registerUserWP($login, $password, $dataUserExternal);
            } else {
                wp_clear_auth_cookie();
                do_action('wp_login', $user->ID);
                wp_set_current_user($user->ID);
                wp_set_auth_cookie($user->ID, true);
                $redirect_to = $_SERVER['REQUEST_URI'];
                $idUser = $user->ID;
                //Login::saveDataUser($idUser,  $dataUserExternal);
                wp_safe_redirect(get_site_url(). "/comunidade/feeds");
                exit;
            }
        }
        public static function registerUserWP($login, $password, $dataUserExternal){
           
           $arrayName =  Login::split_name($dataUserExternal['name']);

           $first_name = $arrayName['first_name'];
           $middle_name =  $arrayName['middle_name'];
           $last_name = $arrayName['last_name'];

           if (!empty($middle_name) && !is_null($middle_name)) {
            $last_name = $middle_name . " " . $last_name;
           }

           /*echo $first_name . "<br>";
           echo $middle_name  . "<br>";
           echo $last_name  . "<br>";
           exit;*/

 
            $WP_array = array (
                'user_login'    =>  $login,
                'user_email'    =>  $dataUserExternal['email'],
                'user_pass'     =>  $password,
                'user_url'      =>  '',
                'display_name'  =>  $first_name,
                'first_name'    =>  $first_name,
                'last_name'     =>  $arrayName['last_name'] ,
                'nickname'      =>  $dataUserExternal['first_name'],
                'description'   =>  '',
                'role' => 'author', 
            ) ;
            $idUser = wp_insert_user( $WP_array ) ;
            Login::saveDataUser($idUser,  $dataUserExternal);
            Login::loginWP($login, $password, $dataUserExternal);
        }
        public  static function forceRedirectLogin(){

            if(is_user_logged_in() && current_user_can('administrator')) {
                return "[form_login_custom]";
             }
        	if(!is_user_logged_in()) {
                echo "<div class='sucesso-login'>VOCÊ NÃO ESTÁ LOGADO, REDIRECIONANDO...</div>";
            	wp_redirect( get_site_url(). "/comunidade");
            	exit();
           }
        }

        public  static function forceRedirectLogoult(){

            if(is_user_logged_in() && current_user_can('administrator')) {
                return "[force_redirect_logoult]";
             }
        	if( is_user_logged_in()) {
                echo "<div class='sucesso-login'>VOCÊ JÁ ESTÁ LOGADO, REDIRECIONANDO...</div>";
                wp_logout();
                wp_redirect( get_site_url() ."/comunidade");
                exit();
           }else{
                wp_redirect( get_site_url() ."/comunidade");
                exit();
           }
        }
        public static function saveDataUser($idUser,  $dataUserExternal){

           if (isset($dataUserExternal) && array_key_exists("name", $dataUserExternal)) {
                $nome = $dataUserExternal["name"];
            } else {
                $nome = '';
            }
            if (isset($dataUserExternal) && array_key_exists("idUser", $dataUserExternal)) {
                $cpf = $dataUserExternal["idUser"];
            } else {
                $cpf = '';
            }
            if (isset($dataUserExternal) && array_key_exists("telefone", $dataUserExternal)) {
                $telefone = $dataUserExternal["telefone"];
            } else {
                $telefone = '';
            }

            if (isset($dataUserExternal) && array_key_exists("codigo_entidade", $dataUserExternal)) {
                $codigo_entidade = $dataUserExternal["codigo_entidade"];
            } else {
                $codigo_entidade = '';
            }
            if (isset($dataUserExternal) && array_key_exists("operador", $dataUserExternal)) {
                $operador = $dataUserExternal["operador"];
            } else {
                $operador = '';
            }
     
            if (isset($dataUserExternal) && array_key_exists("token", $dataUserExternal)) {
                $token = $dataUserExternal["token"];
            } else {
                $token = '';
            }

           /* update_user_meta( $idUser, 'user-cpf', $cpf );
            update_user_meta( $idUser, 'user-seller', $nome );
            update_user_meta( $idUser, 'user-telephone', $telefone );
            update_user_meta( $idUser, 'user-code-operating', $operador );
            update_user_meta( $idUser, 'user-code-entity', $codigo_entidade );
            update_user_meta( $idUser, 'token', $token );*/
           
        }
        public static function split_name($nameFull){
        
            if (empty($nameFull) || is_null($nameFull)) {
                return ""; // Retorne um valor padrão caso esteja vazia ou nula
            }
            $arr = explode(' ', $nameFull);
            $num = count($arr);
            $first_name = $middle_name = $last_name = null;
            if ($num >  0) {
                $first_name = $arr[0];
            }
            if ($num >= 2) {
                $last_name = $arr[$num - 1];
            }
        
            if ($num > 2) {
                $middle_name = implode(' ', array_slice($arr, 1, $num - 2));
            }
            return  compact('first_name', 'middle_name', 'last_name');
        }
    }
?>
<?php

class FakenewsAPI extends WP_REST_Controller {

    public function __construct() {
        // set de variaveis
        $this->version = "1";
        $this->namespace = "fakenews/v" . $this->version;
        // Registra pontos da API REST
        $this->registerPOST("post", "createPost");
        $this->registerPOST("vote", "addVote");
        $this->registerDELETE("vote", "deleteVote");
        $this->registerGET("check", "verificador");
    }

    public function verificador(WP_REST_Request $request){
        return new WP_REST_Response(array("mensagem" => "API functionando"), 200);
    }

    public function createPost(WP_REST_Request $request){
        if(!(isset($request["title"]) && isset($request["content"]) && isset($request["author"]))){
            return new WP_REST_Response(array("mensagem" => "Os campos nao foram informados corretamente"), 400);
        }

        $args = array(
            'post_title'    => $request["title"],
            'post_content'  => $request["content"],
            'post_status'   => 'publish',
            'post_author'   => $request["author"],
        );

        $post_id = wp_insert_post( $args );

        $url = get_post_permalink($post_id);

        return new WP_REST_Response(array("mensagem" => "Post criado com sucesso", "url" => $url), 200);
    }

    public function addVote(WP_REST_Request $request){
        if(!(isset($request["post"]) && isset($request["user"]) && isset($request["action"]))){
            return new WP_REST_Response(array("mensagem" => "Os campos nao foram informados corretamente"), 400);
        }

        $post_id    = $request["post"];
        $user_id    = $request["user"];
        $vote       = $request["action"];

        $votes = get_post_meta($post_id, $vote, TRUE);
        if(!is_array($votes)) $votes = [];
        
        array_push($votes, $user_id);

        update_post_meta($post_id, $vote, $votes);

        return new WP_REST_Response(array("mensagem" => "Voto registrado com sucesso"), 200);
    }

    public function deleteVote(WP_REST_Request $request){
        if(!(isset($request["post"]) && isset($request["user"]) && isset($request["action"]))){
            return new WP_REST_Response(array("mensagem" => "Os campos nao foram informados corretamente"), 400);
        }

        $post_id    = $request["post"];
        $user_id    = $request["user"];
        $vote       = $request["action"];

        $votes = get_post_meta($post_id, $vote, TRUE);
        if(!is_array($votes) || !in_array($user_id, $votes)){
            return new WP_REST_Response(array("mensagem" => "Nao foi remover o voto"), 400);
        }
        $index = array_search($user_id, $votes);
        unset($votes[$index]);
        $new_votes = array_values($votes);

        update_post_meta($post_id, $vote, $new_votes);

        return new WP_REST_Response(array("mensagem" => "Voto excluido com sucesso"), 200);
    }
    
    public function registerPOST($pEndpoint, $pMethod) {
        register_rest_route($this->namespace, "/" . $pEndpoint, [
            [
                "methods" => "POST",
                "callback" => [$this, $pMethod]
            ]
        ]);
    }

    public function registerGET($pEndpoint, $pMethod) {
        register_rest_route($this->namespace, "/" . $pEndpoint, [
            [
                "methods" => "GET",
                "callback" => [$this, $pMethod]
            ]
        ]);
    }

    public function registerDELETE($pEndpoint, $pMethod) {
        register_rest_route($this->namespace, "/" . $pEndpoint, [
            [ 
                "methods" => "DELETE",
                "callback" => [$this, $pMethod]
            ]
       ]);
    }
}
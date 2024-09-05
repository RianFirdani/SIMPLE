<?php
function is_logged_in(){
$s = get_instance();
    if (!$s->session->userdata('email')) {
        redirect('auth');
    }else{
        $role_id = $s->session->userdata('role_id');
        $menu = $s->uri->segment(1);

        $queryMenu  = $s->db->get_where('user_menu',['menu' => $menu ])->row_array();
        $menu_id = $queryMenu['id'];

        $userAcces = $s->db->get_where('user_access_menu',
        [
            'role_id' => $role_id,
            'menu_id' => $menu_id,
        ]);
        if ($userAcces->num_rows()<1) {
            redirect('auth/blocked');
        }
    }
}

function check_access($role_id,$menu_id){
    $s = get_instance();
    $s->db->where('role_id',$role_id);
    $s->db->where('menu_id',$menu_id);  
    $result = $s->db->get('user_access_menu');
    if ($result->num_rows()>0) {
        return "checked='checked'";
    }

}
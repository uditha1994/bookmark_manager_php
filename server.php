<?php
header('Content-Type: application/json');

//define the JSON file path
$file = 'bookmarks.json';

//initialize the file if it doesn't exist
if(!file_exists($file)){
    file_put_contents($file, '[]');
}

//Get the request action
$action = $_REQUEST['action'] ?? '';

//handle different actions
switch($action){
    case 'get':
        //return all bookmarks
        echo file_get_contents($file);
        break;

    case 'add':
        //add a new bookmark
        $bookmarks = json_decode(file_get_contents
        ($file), true); 
        
        $newBookmark = [
            'id' => uniqid(),
            'title' => $_POST['title'],
            'url' => $_POST['url'],
            'created_at' => date('Y-m-d H:i:s')
        ];

        $bookmarks[] = $newBookmark;
        file_put_contents($file, 
        json_encode($bookmarks, 
        JSON_PRETTY_PRINT));

        echo json_encode(['status' => 'success']);
        break;

    case 'delete':
        //Delete a bookmarks
        $bookmarks = json_decode(file_get_contents($file), true);
        $id = $_POST['id'];

        $bookmarks = array_filter($bookmarks, 
        function($bookmark) use ($id){
            return $bookmark['id'] != $id;
        });

        file_put_contents($file, 
        json_encode(array_values($bookmarks), 
        JSON_PRETTY_PRINT));

        echo json_encode(['status' => 'success']);
        break;

    default: 
        echo json_encode(['status' => 'error', 
        'message'=>'Invalid action']);
}
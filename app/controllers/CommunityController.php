<?php

class CommunityController extends BaseController {
	
	public function showCommunity() {
	
	/**
	  *	New call to API.
	  */

	 // get the list of tags
	 $tags = json_decode(file_get_contents('http://toilers.mines.edu/csconnect-pchoi/apiTags'));

	 // convert
	 $testing = array();
	 
	 foreach ($tags as $tag) {
	 
	 	$testing2 = array();
	 	
	 	// going from stdObject to array
	 	// not casting because we also need short_name
	 	$testing2['id'] = $tag->id;
	 	$testing2['name'] = $tag->name;
	 	$testing2['short_name'] = $tag->name;
	 	
	 	array_push($testing, $testing2);
	 	
	 }
	 
	 /**
	  *	Swap result between the APIs.
	  */
	 $interests = $testing;
	 
	 /**
	  *	New way of adding is_mine flag.
	  */
	 
	 $myTags = json_decode(file_get_contents('http://toilers.mines.edu/csconnect-pchoi/myTags'));
	 
	 $myTags2 = array();
	 
	 foreach ($myTags as $oneOfMyTags) {
	 	array_push($myTags2, $oneOfMyTags);
	 }
	 
	 for ($i = 0; $i < count($interests); $i++) {
	 	$interests[$i]['is_mine'] = in_array($interests[$i]['id'], $myTags2);
	 }
	 
	 /**
	  *	Now figure out which page to present.
	  */
	  
	 /*
	 
	 // Check which version of the page to show (interests or users)
	 if (isset($_GET['interest_area'])) {
	 	  	// Get the selected interest
	 	$selected_interest = null;
	 	foreach ($interests as $interest) {
	 		if ($interest['short_name'] == urldecode(trim($_GET['interest_area']))) {
	 			$selected_interest = $interest;
	 			break;
	 		}
	 	}
	 	
	 	  // Get the user that will be centered in the graph
	 	if (isset($_GET['code'])) {
	 		$code = $_GET['code'];
	 		if ($code == "You") {
	 			$code = $current_user['id'];
	 			
	 			if (!$current_user['connections_share']) {
	 				$code = $connections_ops->get_most_connected_user_in_interest_area($selected_interest['name']);
	 	        //NOTE: code will be -1 when no users are in this interest area
	 				$logger->log("Viewed most connected user ".$code." in ".$selected_interest['name'], "Community");
	 			}
	 		}
	 	} else {
	 	    // Set to the current user if the current user is in the interest otherwise get the most connected user
	 		if ($selected_interest['is_mine'] && !isset($_GET['view_most_connected'])  && $current_user['connections_share']) {
	 			$code = $current_user['id'];
	 		} else {
	 			$code = $connections_ops->get_most_connected_user_in_interest_area($selected_interest['name']);
	 	      //NOTE: code will be -1 when no users are in this interest area
	 			$logger->log("Viewed most connected user ".$code." in ".$selected_interest['name'], "Community");
	 		}
	 	}
	 	
	 	if ($code != -1) {
	 		if ($code != $current_user['id']) {
	 			$similarities = $logger->generate_similarities($code);
	 			$logger->log("Viewed ".$code."'s connections in ".$selected_interest['name'].". Similarities: ".$similarities, "Community");
	 		} else {
	 			$logger->log("Viewed own connections in ".$selected_interest['name'], "Community");
	 		}
	 	} else {
	 		$logger->log("Viewed ".$selected_interest['name'], "Community");
	 	}
	 	
	 	$connections = array();
	 	$connections = $connections_ops->get_connections_with_user_in_interest_area($selected_interest['name'], $code);
	 	
	 	$node_list = array();
	 	foreach ($connections as $user_id => $connection_status) {
	 		if ($connection_status['has_met']) {
	 			$node = array("user_id" => $user_id, "type" => "connected", "color" => "#22B14C");
	 			array_push($node_list, $node);
	 		} elseif ($connection_status['has_messaged'] || $connection_status['has_received_message']) {
	 			$node = array("user_id" => $user_id, "type" => "messaged", "color" => "#FFFF00");
	 			array_push($node_list, $node);
	 		} elseif ($connection_status['wants_to_meet']) {
	 			$node = array("user_id" => $user_id, "type" => "wants_to_meet", "color" => "#FF0000");
	 			array_push($node_list, $node);
	 		}
	 	}
	 	
	 	$encoded_current_user_id = htmlspecialchars(json_encode($current_user['id']), ENT_QUOTES);
	 	$encoded_code = htmlspecialchars(json_encode($code), ENT_QUOTES);
	 	$encoded_node_list = htmlspecialchars(json_encode($node_list), ENT_QUOTES);
	 	
	 	$onLoad = "init(".$encoded_code.",".$encoded_node_list.",".$encoded_current_user_id.");";
	 	
	 	  // Get user ids in interest area
	 	$user_ids = $connections_ops->get_all_users_in_interest_area($selected_interest['name']);
	 	
	 	  // Get the ids of those visible in the graph
	 	$graph_user_ids = array();
	 	array_push($graph_user_ids, $code);
	 	foreach ($node_list as $node) {
	 		array_push($graph_user_ids, $node['user_id']);
	 	}
	 	
	 	  // Remove users who are visible in the graph from the other users
	 	for ($i = 0; $i < count($graph_user_ids); $i++) {
	 		if(($index = array_search($graph_user_ids[$i], $user_ids)) !== false) {
	 			unset($user_ids[$index]);
	 		}
	 	}
	 	
	 	$users = array();
	 	foreach ($user_ids as $id) {
	 		array_push($users, $data_ops->get_user_info($id));
	 	}
	 	
	 	for ($i=0; $i < count($users); $i++) {
	 		$users[$i]["roles"] = $data_ops->get_user_characteristic('role', $users[$i]['id']);
	 		$users[$i]["interests"] = $data_ops->get_user_characteristic('interest', $users[$i]['id']);
	 		$users[$i]["objectives"] = $data_ops->get_user_characteristic('objective', $users[$i]['id']);
	 		$users[$i]["goals"] = $goals_ops->get_all_goals($users[$i]['id']);
	 	}
	 	
	 	$graph_users = array();
	 	foreach ($graph_user_ids as $graph_user_id) {
	 		array_push($graph_users, $data_ops->get_user_info($graph_user_id));
	 	}
	 	
	 	for ($i=0; $i < count($graph_users); $i++) {
	 		$graph_users[$i]["roles"] = $data_ops->get_user_characteristic('role', $graph_users[$i]['id']);
	 		$graph_users[$i]["interests"] = $data_ops->get_user_characteristic('interest', $graph_users[$i]['id']);
	 		$graph_users[$i]["objectives"] = $data_ops->get_user_characteristic('objective', $graph_users[$i]['id']);
	 		$graph_users[$i]["goals"] = $goals_ops->get_all_goals($graph_users[$i]['id']);
	 	}
	 	
	 	$smarty->assign('countries', $countries);
	 	$smarty->assign('usStates', $usStates);
	 	$smarty->assign('canadianProvinces', $canadianProvinces);
	 	
	 	$smarty->assign('objectives', $data_ops->get_list("objective", "name"));
	 	$smarty->assign('roles', $data_ops->get_list("role", "id"));
	 	$smarty->assign('interests', $data_ops->get_list("interest", "name"));
	 	
	 	$smarty->assign("header", $selected_interest['name']);
	 	$smarty->assign("selected_interest", $selected_interest);
	 	$smarty->assign("no_connections", empty($connections) && $current_user['id'] == $code);
	 	$smarty->assign("no_users", empty($connections) && $code == -1);
	 	$smarty->assign("private_connections", !$current_user["connections_share"]);
	 	$smarty->assign("onLoad", $onLoad);
	 	$smarty->assign("user_view", true);
	 	$smarty->assign("users", $users);
	 	$smarty->assign("visibleUsers", $graph_users);
	 } else {
	 	$encoded_interests = htmlspecialchars(json_encode($interests), ENT_QUOTES);
	 	
	 	$onLoad = "init(".$encoded_interests.");";
	 	
	 	$logger->log("Viewed interest areas", "Community");
	 	
	 	$smarty->assign("header", "Interest Areas");
	 	$smarty->assign("onLoad", $onLoad);
	 	$smarty->assign("interests", $interests);
	 	$smarty->assign("user_view", false);
	 }
	 
	 */
	 
	 $encoded_interests = htmlspecialchars(json_encode($interests), ENT_QUOTES);
	 
	 $onLoad = "init(".$encoded_interests.");";
	 
	 return View::make('community')
	 	->with('onLoad', $onLoad)
	 	->with('interests', $interests)
	 	->with('user_view', false)
	 	->with('header', 'Hashtags')
	 	->with('user', Auth::user());
	 
	 }

}
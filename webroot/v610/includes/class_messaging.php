<?
#################################################################
## PHP Pro Bid v6.10															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

class messaging extends database
{
	/**
	 * message_handle values:
	 *
	 * 1.- public message
	 * 2.- private message
	 * 3.- successful sale
	 */

	/**
	 * this function will create a new topic. This will be called when a new public/private question is made,
	 * or when a successful sale is made, and no topic is made yet
	 */
	function new_topic($auction_id, $sender_id, $receiver_id, $is_question, $message_title, $message_content, $message_handle, $winner_id=0, $admin_message = 0)
	{
		$id_field = (in_array($message_handle, array(4, 5))) ? 'wanted_ad_id' : 'auction_id';
		$id_field = (in_array($message_handle, array(15))) ? 'reverse_id' : $id_field;
		
		$winner_field = (in_array($message_handle, array(15))) ? 'bid_id' : 'winner_id';
		
      $word_filter = array('message_title' => $message_title, 'message_content' => $message_content);
      $word_filter = ($admin_message) ? $word_filter : word_filter($word_filter);
      
      $message_title = $word_filter['message_title'];
      $message_content = $word_filter['message_content'];

      $sql_create_topic = $this->query("INSERT INTO " . DB_PREFIX . "messaging
			(" . $id_field . ", sender_id, receiver_id, is_question, message_title, message_content, reg_date, message_handle, 
			" . $winner_field . ", admin_message) VALUES
			('" . $auction_id . "', '" . $sender_id . "', '" . $receiver_id . "', '" . $is_question . "',
			'" . $this->rem_special_chars($message_title) . "', '" . $this->rem_special_chars($message_content) . "',
			'" . CURRENT_TIME . "', '" . $message_handle . "', '" . $winner_id . "', '" . $admin_message . "')");

		$topic_id = $this->insert_id();

		if ($winner_id > 0)
		{
			$table_name = ($id_field == 'reverse_id') ? 'reverse_bids' : 'winners';
			$field_name = ($id_field == 'reverse_id') ? 'bid_id' : 'winner_id';
			
			$this->query("UPDATE " . DB_PREFIX . $table_name . " SET messaging_topic_id=" . $topic_id . " WHERE " . $field_name . "=" . $winner_id);
		}
		$sql_update_topic = $this->query("UPDATE " . DB_PREFIX . "messaging SET
			topic_id=" . $topic_id . " WHERE message_id=" . $topic_id);
		
		$mail_input_id = $topic_id;
		if ($admin_message)
		{
			include('../language/' . $this->setts['site_lang'] . '/mails/new_message_receiver_notification.php');			
		}
		else 
		{
			include('language/' . $this->setts['site_lang'] . '/mails/new_message_receiver_notification.php');
			include('language/' . $this->setts['site_lang'] . '/mails/new_message_sender_notification.php');
		}

		return $topic_id;
	}

	/**
	 * this function will only be used for replies, and will only work if a topic already exists
	 */
	function reply($topic_id, $sender_id, $message_title, $message_content)
	{
		$output = false; // output will be either false or the id of the message posted
		
		$topic_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "messaging WHERE
			topic_id=" . $topic_id . " LIMIT 1");

		## if message handle=1, then only INSERT if there is no answer, otherwise UPDATE the answer
		if ($topic_details)
		{
			$output = true;
			
			## modified this line so that 2 messages can be added on a topic without the user receiving having to respond
			$receiver_id = ($topic_details['sender_id'] != $sender_id) ? $topic_details['sender_id'] : $topic_details['receiver_id'];

			$reply_details = $this->get_sql_row("SELECT * FROM " . DB_PREFIX . "messaging WHERE
				message_id!=" . $topic_details['message_id'] . " AND topic_id=" . $topic_id . " AND sender_id=" . $sender_id);

         $word_filter = array('message_title' => $message_title, 'message_content' => $message_content);
         $word_filter = word_filter($word_filter);

         $message_title = $word_filter['message_title'];
         $message_content = $word_filter['message_content'];
      
      
			if (($topic_details['message_handle'] == 1 || $topic_details['message_handle'] == 4) && $reply_details) ## reply exists and Public Question, UPDATE
			{
				$sql_update_reply = $this->query("UPDATE " . DB_PREFIX . "messaging SET
					message_title='" . $this->rem_special_chars($message_title) . "',
					message_content='" . $this->rem_special_chars($message_content) . "',
					reg_date='" . CURRENT_TIME . "' WHERE message_id='" . $reply_details['message_id'] . "'");
				
				$mail_input_id = $reply_details['message_id'];

			}
			else ## above condition not met, INSERT message
			{
				$sql_insert_reply = $this->query("INSERT INTO " . DB_PREFIX . "messaging
					(auction_id, topic_id, sender_id, receiver_id, is_question, message_title, message_content, reg_date,
					message_handle, winner_id, wanted_ad_id, reverse_id, bid_id) VALUES
					('" . $topic_details['auction_id'] . "', '" . $topic_id . "', '" . $sender_id . "', '" . $receiver_id . "',
					'0', '" . $this->rem_special_chars($message_title) . "',
					'" . $this->rem_special_chars($message_content) . "',	'" . CURRENT_TIME . "',
					'" . $topic_details['message_handle'] . "', '" . $topic_details['winner_id'] . "', 
					'" . $topic_details['wanted_ad_id'] . "', '" . $topic_details['reverse_id'] . "', '" . $topic_details['bid_id'] . "')");
				
				$mail_input_id = $this->insert_id();
			}	

			include('language/' . $this->setts['site_lang'] . '/mails/new_message_receiver_notification.php');
			include('language/' . $this->setts['site_lang'] . '/mails/new_message_sender_notification.php');
		}

		return $output;
	}

	/**
	 * this will only mark the message as deleted, and the message is only removed from the table if its marked deleted
	 * by both the sender and the receiver
	 */
	function delete_message($message_id, $user_id, $deletion_type)
	{
		$run_query = false;

		if ($deletion_type == 'receiver_deleted')
		{
			$run_query = true;
			$sql_query = "UPDATE " . DB_PREFIX . "messaging SET receiver_deleted=1 WHERE
				message_id='" . $message_id . "' AND receiver_id='" . $user_id . "'";
		}
		else if ($deletion_type == 'sender_deleted')
		{
			$run_query = true;
			$sql_query = "UPDATE " . DB_PREFIX . "messaging SET sender_deleted=1 WHERE
				message_id='" . $message_id . "' AND sender_id='" . $user_id . "'";
		}

		if ($run_query)
		{
			$this->query($sql_query);
		}


	}

	/**
	 * only the admin can delete a whole topic.
	 */
	function delete_topic($topic_id)
	{
		$output = false;

		if (IN_ADMIN == 1)
		{
			$output = true;
			$this->query("DELETE FROM " . DB_PREFIX . "messaging WHERE topic_id='" . $topic_id . "'");
		}

		return $output;
	}

	/**
	 * this function will be used to retrieve all public messages for an auction
	 * it will include questions and answers. the data will be processed on the auction details page
	 */
	function public_messages($auction_id, $message_handle = 1)
	{
		$id_field = (in_array($message_handle, array(4, 5))) ? 'wanted_ad_id' : 'auction_id';
		
		$output = $this->query("SELECT q.message_id AS question_id, q.message_content AS question_content, q.reg_date AS question_date,
			a.message_content AS answer_content, a.reg_date AS answer_date, q.topic_id FROM " . DB_PREFIX . "messaging q
			LEFT JOIN " . DB_PREFIX . "messaging a ON a.is_question=0 AND a.topic_id=q.topic_id WHERE
			q." . $id_field . "=" . $auction_id . " AND q.message_handle=" . $message_handle . " AND q.is_question=1 ORDER BY q.reg_date DESC");

		return $output;
	}

	function message_subject($message_details) ## it is presumed the auction name is available in the array, message_handle as well
	{
		(string) $display_output = null;

		switch ($message_details['message_handle'])
		{
			case 1:
				$display_output = MSG_PUBLIC_QUESTION . '<br>' .
					MSG_AUCTION_ID . ': ' . $message_details['auction_id'] . ' - ' . $message_details['name'];
				break;
			case 2:
				$display_output = MSG_PRIVATE_QUESTION . '<br>' .
					MSG_AUCTION_ID . ': ' . $message_details['auction_id'] . ' - ' . $message_details['name'];
				break;
			case 3:
				$display_output = MSG_SUCCESSFUL_SALE . '<br>' .
					MSG_AUCTION_ID . ': ' . $message_details['auction_id'] . ' - ' . $message_details['name'];
				break;
			case 4:
				$display_output = MSG_PUBLIC_QUESTION . ' - ' . GMSG_WANTED_AD . '<br>' .
					MSG_WANTED_AD_ID . ': ' . $message_details['wanted_ad_id'] . ' - ' . $message_details['wanted_name'];
				break;
			case 5:
				$display_output = MSG_PRIVATE_QUESTION . ' - ' . GMSG_WANTED_AD . '<br>' .
					MSG_WANTED_AD_ID . ': ' . $message_details['wanted_ad_id'] . ' - ' . $message_details['wanted_name'];
				break;
			case 15:
				$display_output = MSG_PMB . ' - ' . MSG_REVERSE_AUCTION . '<br>' .
					MSG_AUCTION_ID . ': ' . $message_details['reverse_id'] . ' - ' . $message_details['reverse_name'];
				break;
			default:
				$display_output = $message_details['message_title'];
		}
		return $display_output;
	}

	function msg_board_link($message_details)
	{
		(string) $output = null;

		switch ($message_details['message_handle'])
		{
			case 1:
				$output = process_link('auction_details', array('auction_id' => $message_details['auction_id']));
				break;
			case 3:
				$output = process_link('message_board', array('topic_id' => $message_details['topic_id'], 'winner_id' => $message_details['winner_id']));
				break;
			case 4:
				$output = process_link('wanted_details', array('wanted_ad_id' => $message_details['wanted_ad_id']));
				break;
			case 15:
				$output = process_link('message_board', array('topic_id' => $message_details['topic_id'], 'bid_id' => $message_details['bid_id']));
				break;
			default:
				$output = process_link('message_board', array('topic_id' => $message_details['topic_id']));
		}
		return $output;
	}

	function mark_read($receiver_id, $topic_id, $auction_id, $message_handle)
	{
		$id_field = (in_array($message_handle, array(4, 5))) ? 'wanted_ad_id' : 'auction_id';
		$id_field = (in_array($message_handle, array(15))) ? 'reverse_id' : $id_field;
		
		$is_unread = $this->count_rows('messaging', "WHERE
			receiver_id='" . $receiver_id . "' AND (" . $id_field . "='" . $auction_id . "' OR topic_id='". $topic_id . "') AND
			message_handle=" . $message_handle . " AND is_read=0");

		if ($is_unread)
		{
			## we either mark as read by topic id or by auction id
			$sql_mark_read = $this->query("UPDATE " . DB_PREFIX . "messaging SET is_read=1 WHERE
				receiver_id='{$receiver_id}' AND (
					" . (($message_handle != 0) ? "`{$id_field}`='{$auction_id}' OR " : '') . "
					topic_id='{$topic_id}') AND
				message_handle='{$message_handle}'");
		}
	}
}

?>
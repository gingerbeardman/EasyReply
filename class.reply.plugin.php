<?php if (!defined('APPLICATION')) exit();
/*
Copyright 2010 NeuPioneer
This file is not part of Garden.
Garden is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
Garden is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with Garden.  If not, see <http://www.gnu.org/licenses/>.

*/

// Define the plugin:
$PluginInfo['EasyReply'] = array(
   'Name' => 'EasyReply',
   'Description' => "Add a Reply Button to each post/comment(display as '@username'). Also add Ctrl+Enter Reply shortcut. 本插件用于方便用户回复. 来自东北大学先锋网技术部.",
   'Version' => '1.1',
   'MobileFriendly' => FALSE,
   'RequiredApplications' => FALSE,
   'RequiredTheme' => FALSE, 
   'RequiredPlugins' => FALSE,
   'HasLocale' => TRUE,
   'RegisterPermissions' => FALSE,
   'Author' => "andelf",
   'AuthorEmail' => 'andelf@gmail.com',
   'AuthorUrl' => 'http://www.neupioneer.com',
   'License' => 'GPLv3'
);

class EzReplyPlugin extends Gdn_Plugin {

   public function PluginController_EzReply_Create($Sender) {
		$this->Dispatch($Sender, $Sender->RequestArgs);
   }
   /*
   public function DiscussionController_Render_Before($Sender) {
      $this->PrepareController($Sender);
   }
   
   public function PostController_Render_Before($Sender) {
      $this->PrepareController($Sender);
   }

   public function MessagesController_Render_Before($Sender) {
      $this->PrepareController($Sender);
   }

   public function ProfileController_Render_Before($Sender) {
      $this->PrepareController($Sender);
   }
   */

   public function Base_Render_Before($Sender) {
      $this->PrepareController($Sender);
   }

   protected function PrepareController($Sender) {
      $Sender->AddJsFile($this->GetResource('js/ezreply.js', FALSE, FALSE));
   }
   
   public function DiscussionController_CommentOptions_Handler($Sender) {
      $this->AddReplyButton($Sender);
   }
   
   public function PostController_CommentOptions_Handler($Sender) {
      $this->AddReplyButton($Sender);
   }
   
   protected function AddReplyButton($Sender) {
      if (!Gdn::Session()->UserID) return;
      
      if (isset($Sender->EventArguments['Comment'])) {
        $Model = new CommentModel();
        $Data = $Model->GetID( $Sender->EventArguments['Comment']->CommentID );
      } else {
        $Model = new DiscussionModel();
        $Data = $Model->GetID( $Sender->Data['Discussion']->DiscussionID );
      }

      $ReplyURL = "#"."{$Data->InsertName}";
      $ReplyText = T('Reply');
      echo <<<QUOTE
      <span class="CommentReply"><a href="{$ReplyURL}">{$ReplyText}</a></span>
QUOTE;
   }
   
   public function Setup() {
      SaveToConfig('Garden.Html.SafeStyles',FALSE);
   }
   
   public function OnDisable() {
      RemoveFromConfig('Garden.Html.SafeStyles');
   }
   
   public function Structure() {
      // Nothing to do here!
   }
         
}

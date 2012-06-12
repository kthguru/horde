<?php echo $this->topbar ?>
<div id="horde-page" style="display:none">
<?php echo $this->sidebar ?>
 <div id="dimpmain">
  <div id="dimpmain_iframe"><?php echo _("Loading...") ?></div>
  <div id="dimpmain_folder" style="display:none">
   <div id="dimpmain_folder_top">
    <div class="header mboxheader">
     <div>
      <span class="rightFloat" id="msgHeader"></span>
      <span id="mailboxName"></span>
      <span class="iconImg readonlyImg" style="display:none" title="<?php echo $this->h(_("Read-Only")) ?>"></span>
     </div>
    </div>

    <div class="dimpActions">
<?php if ($this->show_search): ?>
     <div id="qsearch">
      <span id="qsearch_icon">
       <span class="iconImg searchImg"></span>
       <span class="iconImg popdownImg"></span>
      </span>
      <form action="#" method="post">
       <input autocomplete="off" id="qsearch_input" type="text" />
      </form>
     </div>
     <div id="filter">
      <?php echo $this->actionButton(array('icon' => 'Filter', 'id' => 'button_filter', 'title' => _("Filter"))) ?>
     </div>
<?php endif; ?>
     <div>
      <?php echo $this->actionButton(array('class' => 'noselectDisable', 'icon' => 'Reply', 'id' => 'button_reply', 'title' => _("Reply"))) ?>
     </div>
     <div>
      <?php echo $this->actionButton(array('class' => 'noselectDisable', 'icon' => 'Forward', 'id' => 'button_forward', 'title' => _("Forward"))) ?>
     </div>
<?php if ($this->show_spam): ?>
     <div style="display:none">
      <?php echo $this->actionButton(array('class' => 'noselectDisable', 'icon' => 'Spam', 'id' => 'button_spam', 'title' => _("Spam"))) ?>
     </div>
<?php endif; ?>
<?php if ($this->show_notspam): ?>
     <div style="display:none">
      <?php echo $this->actionButton(array('class' => 'noselectDisable', 'icon' => 'Ham', 'id' => 'button_ham', 'title' => _("Innocent"))) ?>
     </div>
<?php endif; ?>
     <div style="display:none">
      <?php echo $this->actionButton(array('class' => 'noselectDisable', 'icon' => 'Resume', 'id' => 'button_resume', 'title' => _("Resume"))) ?>
     </div>
     <div style="display:none">
      <?php echo $this->actionButton(array('icon' => 'Resume', 'id' => 'button_template', 'title' => _("Use Template"))) ?>
     </div>
     <div>
      <?php echo $this->actionButton(array('class' => 'noselectDisable', 'icon' => 'Delete', 'id' => 'button_delete', 'title' => _("Delete"))) ?>
     </div>
     <div id="button_compose">
      <?php echo $this->actionButton(array('icon' => 'Compose', 'title' => _("Compose"))) ?>
     </div>
     <div id="button_checkmail">
      <?php echo $this->actionButton(array('icon' => 'Checkmail', 'title' => _("Get Mail"))) ?>
     </div>
     <div>
      <?php echo $this->actionButton(array('icon' => 'Other', 'id' => 'button_other', 'title' => _("Other"))) ?>
     </div>
    </div>

    <div id="searchbar" style="display:none">
     <span class="iconImg closeImg" id="search_close" title="<?php echo _("Clear Search") ?>"></span>
     <span class="iconImg dimpactionRefresh" id="search_refresh" title="<?php echo _("Refresh Search Results") ?>"></span>
     <span class="iconImg dimpactionEditsearch" id="search_edit" style="display:none" title="<?php echo _("Edit Search Query") ?>"></span>
     <span id="search_time_elapsed" style="display:none"></span>
     <div id="search_label"></div>
    </div>
   </div>

   <div id="msgSplitPane"></div>

   <div id="previewPane" style="display:none">
    <div id="previewInfo" style="display:none"></div>
    <div id="previewMsg" style="display:none">
     <div class="msgHeaders">
      <div id="toggleHeaders">
       <a id="th_expand"><span class="iconImg" title="<?php echo _("Expand Headers") ?>"></span></a>
       <a id="th_collapse" style="display:none"><span class="iconImg" title="<?php echo _("Collapse Headers") ?>"></span></a>
      </div>
      <div id="msgHeadersColl">
       <a id="msg_newwin"><span class="iconImg" title="<?php echo _("Open in new window") ?>"></span></a>
       <span class="date"></span>
       <span class="subject"></span>
       <span class="fromcontainer"><?php echo _("from") ?>
        <span class="from"></span>
       </span>
      </div>
      <div id="msgHeaders" style="display:none">
       <div class="dimpOptions">
        <div>
         <span id="msg_newwin_options">
          <span class="iconImg"></span>
          <a><?php echo _("Open in new window") ?></a>
         </span>
        </div>
        <div style="display:none">
         <span id="msg_resume_draft">
          <span class="iconImg"></span>
          <a><?php echo _("Resume Draft") ?></a>
         </span>
        </div>
        <div style="display:none">
         <span id="msg_template">
          <span class="iconImg"></span>
          <a><?php echo _("Use Template") ?></a>
         </span>
        </div>
        <div>
         <span id="preview_other_opts">
          <span class="iconImg dimpactionOther"></span>
          <a><?php echo _("Other Options") ?></a>
        </span>
        </div>
       </div>
       <div id="msgHeadersContent">
        <table>
         <thead>
          <tr>
           <td class="label"><?php echo _("Subject") ?>:</td>
           <td class="subject"></td>
          </tr>
          <tr id="msgHeaderFrom">
           <td class="label"><?php echo _("From") ?>:</td>
           <td class="from"></td>
          </tr>
          <tr id="msgHeaderDate">
           <td class="label"><?php echo _("Date") ?>:</td>
           <td class="date"></td>
          </tr>
          <tr id="msgHeaderTo">
           <td class="label"><?php echo _("To") ?>:</td>
           <td class="to"></td>
          </tr>
          <tr id="msgHeaderCc">
           <td class="label"><?php echo _("Cc") ?>:</td>
           <td class="cc"></td>
          </tr>
          <tr id="msgHeaderBcc">
           <td class="label"><?php echo _("Bcc") ?>:</td>
           <td class="bcc"></td>
          </tr>
          <tr id="msgAtc" style="display:none">
           <td class="label" id="partlist_toggle">
            <span class="iconImg attachmentImg attachmentImage"></span>
            <span class="iconImg" id="partlist_col"></span>
            <span class="iconImg" id="partlist_exp" style="display:none"></span>
           </td>
           <td>
            <div></div>
            <div id="partlist" style="display:none"></div>
           </td>
          </tr>
          <tr id="msgLogInfo" style="display:none">
           <td class="label" id="msgloglist_toggle">
            <span class="iconImg" id="msgloglist_col"></span>
            <span class="iconImg" id="msgloglist_exp" style="display:none"></span>
           </td>
           <td>
            <div>
             <span class="msgLogLabel"><?php echo _("Message Log") ?></span>
            </div>
            <div id="msgloglist" style="display:none">
             <ul></ul>
            </div>
           </td>
          </tr>
         </thead>
        </table>
       </div>
      </div>
     </div>
     <div id="messageBody" class="messageBody"></div>
    </div>
   </div>
  </div>
 </div>
</div>

<div id="helptext">
 <div style="display:none">
  <span class="iconImg closeImg" id="helptext_close" title="<?php echo _("Close") ?>"></span>
  <?php echo _("To preview a message, select it from the message list.") ?>
  <br />
<?php if ($this->is_opera): ?>
  <?php echo _("A left click") ?> + <span class="kbd"><?php echo _("Shift") ?></span> + <span class="kbd"><?php echo _("Ctrl") ?></span> <?php echo _("will display available actions.") ?>
<?php else: ?>
  <?php echo _("A right-click on a message or a mailbox will display available actions.") ?>
<?php endif; ?>
  <br />
  <?php printf(_("Click on a message while holding down the %s key to select multiple messages.  To select a range of messages, click the first message of the range, navigate to the last message of the range, and then click on the last message while holding down the %s key."), '<span class="kbd">' . _("Ctrl") . '</span>', '<span class="kbd">' . _("Shift") . '</span>') ?><br /><br />
  <?php echo _("The following keyboard shortcuts are available:") ?><br />
  <span class="iconImg keyupImg"></span> / <span class="iconImg keydownImg"></span> : <?php echo _("Move up/down through the message list.") ?><br />
  <span class="kbd"><?php echo _("PgUp") ?></span> / <span class="kbd"><?php echo _("PgDown") ?></span> : <?php echo _("Move one page up/down through the message list.") ?><br />
  <span class="kbd"><?php echo _("Alt") ?></span> + <span class="kbd"><?php echo _("PgUp") ?></span> / <span class="kbd"><?php echo _("PgDown") ?></span> : <?php echo _("Scroll up/down through the display of the previewed message.") ?><br />
  <span class="kbd"><?php echo _("Home") ?></span> / <span class="kbd"><?php echo _("End") ?></span> : <?php echo  _("Move to the beginning/end of the message list.") ?><br />
  <span class="kbd"><?php echo _("Del") ?></span> : <?php echo _("Delete the currently selected message(s).") ?> <?php printf(_("%s will delete the current message and move to the next message if a single message is selected."), '<span class="kbd">' . _("Shift") . '</span> + <span class="kbd">' . _("Del") . '</span>') ?><br />
  <span class="kbd"><?php echo _("Shift") ?></span> + <span class="kbd"><?php echo _("N") ?></span> : <?php echo _("Move to the next unseen message (non-search mailboxes only).") ?><br />
  <span class="kbd"><?php echo _("Enter") ?></span> : <?php echo _("Open message in a popup window.") ?><br />
  <span class="kbd"><?php echo _("Ctrl") ?></span> + <span class="kbd"><?php echo 'A' ?></span> : <?php echo _("Select all messages in the current mailbox.") ?>
 </div>
</div>

<div id="messageBodyError">
 <table class="mimeStatusMessageTable" style="display:none">
  <tr>
   <td><?php echo _("Unable to view message in preview pane.") ?></td>
  </tr>
  <tr>
   <td><a href="#" class="messageBodyErrorLink"><?php echo _("Click HERE to view the message in a new window.") ?></a></td>
  </tr>
 </table>
</div>

<div id="msglistHeaderContainer">
 <div class="item msglistHeader" id="msglistHeaderHoriz" style="display:none">
  <div class="iconImg msgStatus">
   <div class="iconImg msCheckAll msCheck" id="horiz_opts" title="<?php echo _("Select All") ?>"></div>
  </div>
  <div class="msgFrom sep"></div>
  <div class="msgSubject sep"></div>
  <div class="msgDate sep"></div>
  <div class="msgSize sep"></div>
 </div>
 <div class="item msglistHeader" id="msglistHeaderVert" style="display:none">
  <div class="iconImg msgStatus">
   <div class="iconImg msCheckAll msCheck" title="<?php echo _("Select All") ?>"></div>
  </div>
  <div class="msgSort">
   <a class="widget" id="vertical_sort"><?php echo _("Sort") ?></a>
  </div>
 </div>
</div>
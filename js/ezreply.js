function setCursorPosition(ctrl, pos){
  if(ctrl.setSelectionRange){
    ctrl.focus();
    ctrl.setSelectionRange(pos,pos);
  } else if (ctrl.createTextRange) {
    var range = ctrl.createTextRange();
    range.collapse(true);
    range.moveEnd('character', pos);
    range.moveStart('character', pos);
    range.select();
  }
}

jQuery(document).ready(function(){
  $('textarea#Form_Body').keydown(function (e) {
    if (e.ctrlKey && e.keyCode == 13) {
      if ($('input#Form_PostComment').val())
        $('input#Form_PostComment').click();
      else if ($('input#Form_PostDiscussion').val())
        $('input#Form_PostDiscussion').click();
      else {
        $(this.parentNode.getElementsByClassName('Button')).click();
      }
    }
  });
  $('textarea#Form_Comment').keydown(function (e) {
    if (e.ctrlKey && e.keyCode == 13) {
      // myprofile and other's profile
      $(this.parentNode.getElementsByClassName('Button')).click();
      // $('input#Form_Share,input#Form_AddComment').click();
    }
  });
  $('.CommentReply a').click(function (e) {
    var ipt = $('textarea#Form_Body');
    var name = $(this).attr('href').substring(1);
    if (ipt.val().indexOf('@' + name) < 0)
        ipt.val('@' + name + ' ' + ipt.val());

    $('html,body').animate({scrollTop: ipt.offset().top}, 'fast');
    ipt = ipt[0];
    setCursorPosition(ipt, ipt.textLength);
    ipt.focus();
    return false;
  });
});

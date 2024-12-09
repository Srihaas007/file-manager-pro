
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
  <script type="text/javascript" src="<?php echo ADMIN_URL ?>page/vinod/js/froala_editor.min.js"></script>
  <script type="text/javascript" src="<?php echo ADMIN_URL ?>page/vinod/js/plugins/align.min.js"></script>
  <script type="text/javascript" src="<?php echo ADMIN_URL ?>page/vinod/js/plugins/code_beautifier.min.js"></script>
  <script type="text/javascript" src="<?php echo ADMIN_URL ?>page/vinod/js/plugins/code_view.min.js"></script>
  <script type="text/javascript" src="<?php echo ADMIN_URL ?>page/vinod/js/plugins/draggable.min.js"></script>
  <script type="text/javascript" src="<?php echo ADMIN_URL ?>page/vinod/js/plugins/image.min.js"></script>
  <script type="text/javascript" src="<?php echo ADMIN_URL ?>page/vinod/js/plugins/image_manager.min.js"></script>
  <script type="text/javascript" src="<?php echo ADMIN_URL ?>page/vinod/js/plugins/link.min.js"></script>
  <script type="text/javascript" src="<?php echo ADMIN_URL ?>page/vinod/js/plugins/lists.min.js"></script>
  <script type="text/javascript" src="<?php echo ADMIN_URL ?>page/vinod/js/plugins/paragraph_format.min.js"></script>
  <script type="text/javascript" src="<?php echo ADMIN_URL ?>page/vinod/js/plugins/paragraph_style.min.js"></script>
  <script type="text/javascript" src="<?php echo ADMIN_URL ?>page/vinod/js/plugins/table.min.js"></script>
 <!-- <script  type="text/javascript" src="vinod/js/plugins/video.min.js"></script>-->
  <script type="text/javascript" src="<?php echo ADMIN_URL ?>page/vinod/js/plugins/url.min.js"></script>
  <script type="text/javascript" src="<?php echo ADMIN_URL ?>page/vinod/js/plugins/entities.min.js"></script>

  <script>
      $(function(){
        $('#edit')
          .on('froalaEditor.initialized', function (e, editor) {
            $('#edit').parents('form').on('submit', function () {
              console.log($('#edit').val());
              return false;
            })
          })
          .froalaEditor({enter: $.FroalaEditor.ENTER_P, placeholderText: null})
      });
  </script>
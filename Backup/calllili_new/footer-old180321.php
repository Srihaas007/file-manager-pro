

<!--   FOOTER START================== -->
<style>
	#st-2 {
    font-family: "Helvetica Neue", Verdana, Helvetica, Arial, sans-serif;
    direction: ltr;
    display: block;
    opacity: 1;
   text-align: left; 
    z-index: 94034;
}
	#st-1{
	text-align:left;}
</style>


<?php

// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

	//print_r($_POST);
	$client_ip=get_client_ip();
	if(!empty($_POST['btnAcceptedNew'])=="OK")
	{
		$notification_id= $_POST['notification_id'];
		$client_ip=$_POST['client_ip'];
		$accepted_date=date('Y-m-d');
		$notification_sql=mysqli_query($conn,"INSERT INTO `notification_relation_public`(`notification_id`, `client_ip`, `accepted_date`) VALUES ('$notification_id','$client_ip','$accepted_date')");
	}

	$result_1 = mysqli_query($conn, "SELECT * FROM notification INNER JOIN notification_relation_public ON notification.id = notification_relation_public.notification_id WHERE notification.status ='1' AND notification.view_section='4' AND notification_relation_public.client_ip='".$client_ip."'");
	$tot_notifications=mysqli_num_rows($result_1);
	
	$news_idd=array();
	while ($row_1 = mysqli_fetch_assoc($result_1)) {
		$news_idd[]=$row_1['notification_id'];
	}
	
	if($tot_notifications==0)
	{
		$notin = '';
	}
	else{
		$notin = "id NOT IN ( '" . implode( "', '" , $news_idd ) . "' ) AND";
	}

?>

<script defer src="<?php echo BASE_URL; ?>js/all.js"></script>



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<!--<script src="<?php echo BASE_URL; ?>js/bootstrap.min.js"></script>-->
<!-- Responsive Video Slider JS -->

<!-- Include all compiled plugins (below), or include individual files as needed -->

<script type="text/javascript" src="js/libs/selectivizr.js"></script>

<script type="text/javascript">
    $('.custom_menu_link').mouseover(function(){        
         var size=$(this).parent('.mainli').find('.customdrop li').size();
         if(size > 0)
         {
             $(this).parent('.mainli').find('.customdrop').css('display','none');
         }else
         {
            $(this).parent('.mainli').find('.customdrop').addClass('cusomclass');  
         }
    });
    jQuery(document).ready(function () {

        $('.clickservice').click(function () {

            $('#menu_multi').toggle();
        })

        if ($("body").width() < 450)
        {


            $('#menu_multi').hide();
            $('#menu_multi').removeClass('multi-level');
        } else {

            $('#menu_multi').addClass('multi-level');
        }



        $(".nav li").hover(function () {
                    $('.multi-level', this).fadeIn("fast");
                },
                function () {
                    $('.multi-level', this).fadeOut("fast");
                });
    });
</script>

<script type="text/javascript" src="<?php echo BASE_URL; ?>js/rvslider.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>js/wow.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>js/selectivizr.js"></script>
<script type="text/javascript">
    jQuery(function ($) {
        $('.rvs-container').rvslider();
    });
</script>

<script type="text/javascript" src="js/jquery-listnav.js"></script>
<script type="text/javascript" src="js/vendor.js"></script>
<script type="text/javascript">
    $(function () {
        $('#demoThree').listnav({
            initLetter: 'all',
            includeNums: false
        });
        $('.demo a').click(function (e) {
            e.preventDefault();
        });
    });
</script>


<script type="text/javascript">
    new WOW().init();
</script>

<script type="text/javascript">
    $('.carousel .vertical .item').each(function () {
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));

        for (var i = 1; i < 2; i++) {
            next = next.next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }

            next.children(':first-child').clone().appendTo($(this));
        }
    });
</script>

<script type="text/javascript">
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.navigation').addClass('navbar-fixed-top');
        } else {
            $('.navigation').removeClass('navbar-fixed-top');
        }
    });
</script>

<script type="text/javascript" src="https://cdn.rawgit.com/vaakash/jquery-easy-ticker/master/jquery.easy-ticker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script type="text/javascript">
    $(function () {

        $('.demo1').easyTicker({
            direction: 'up',
            height: '180',
            interval: 10000
        });


        $('.demo2').easyTicker({
            direction: 'down',
        });

        $('.demo3').easyTicker({
            visible: 1,
            interval: 4000
        });

        $('.demo4').easyTicker({
            direction: 'up',
            easing: 'easeOutBounce',
            interval: 2500
        });

        $('.demo5').easyTicker({
            direction: 'up',
            visible: 3,
            easing: 'easeInBack',
            controls: {
                up: '.btnUp',
                down: '.btnDown',
                toggle: '.btnToggle'
            }
        });
    });

</script>
<script type="text/javascript">
    
    $('.news').find('img').css('display','none');
    $(document).ready(function () {
        $('#pinBoot').pinterest_grid({
            no_columns: 4,
            padding_x: 10,
            padding_y: 10,
            margin_bottom: 50,
            single_column_breakpoint: 700
        });
    });

    ;
    (function ($, window, document, undefined) {
        var pluginName = 'pinterest_grid',
                defaults = {
                    padding_x: 10,
                    padding_y: 10,
                    no_columns: 3,
                    margin_bottom: 50,
                    single_column_breakpoint: 700
                },
                columns,
                $article,
                article_width;

        function Plugin(element, options) {
            this.element = element;
            this.options = $.extend({}, defaults, options);
            this._defaults = defaults;
            this._name = pluginName;
            this.init();
        }

        Plugin.prototype.init = function () {
            var self = this,
                    resize_finish;

            $(window).resize(function () {
                clearTimeout(resize_finish);
                resize_finish = setTimeout(function () {
                    self.make_layout_change(self);
                }, 11);
            });

            self.make_layout_change(self);

            setTimeout(function () {
                $(window).resize();
            }, 500);
        };

        Plugin.prototype.calculate = function (single_column_mode) {
            var self = this,
                    tallest = 0,
                    row = 0,
                    $container = $(this.element),
                    container_width = $container.width();
            $article = $(this.element).children();

            if (single_column_mode === true) {
                article_width = $container.width() - self.options.padding_x;
            } else {
                article_width = ($container.width() - self.options.padding_x * self.options.no_columns) / self.options.no_columns;
            }

            $article.each(function () {
                $(this).css('width', article_width);
            });

            columns = self.options.no_columns;

            $article.each(function (index) {
                var current_column,
                        left_out = 0,
                        top = 0,
                        $this = $(this),
                        prevAll = $this.prevAll(),
                        tallest = 0;

                if (single_column_mode === false) {
                    current_column = (index % columns);
                } else {
                    current_column = 0;
                }

                for (var t = 0; t < columns; t++) {
                    $this.removeClass('c' + t);
                }

                if (index % columns === 0) {
                    row++;
                }

                $this.addClass('c' + current_column);
                $this.addClass('r' + row);

                prevAll.each(function (index) {
                    if ($(this).hasClass('c' + current_column)) {
                        top += $(this).outerHeight() + self.options.padding_y;
                    }
                });

                if (single_column_mode === true) {
                    left_out = 0;
                } else {
                    left_out = (index % columns) * (article_width + self.options.padding_x);
                }

                $this.css({
                    'left': left_out,
                    'top': top
                });
            });

            this.tallest($container);
            $(window).resize();
        };

        Plugin.prototype.tallest = function (_container) {
            var column_heights = [],
                    largest = 0;

            for (var z = 0; z < columns; z++) {
                var temp_height = 0;
                _container.find('.c' + z).each(function () {
                    temp_height += $(this).outerHeight();
                });
                column_heights[z] = temp_height;
            }

            largest = Math.max.apply(Math, column_heights);
            _container.css('height', largest + (this.options.padding_y + this.options.margin_bottom));
        };

        Plugin.prototype.make_layout_change = function (_self) {
            if ($(window).width() < _self.options.single_column_breakpoint) {
                _self.calculate(true);
            } else {
                _self.calculate(false);
            }
        };

        $.fn[pluginName] = function (options) {
            return this.each(function () {
                if (!$.data(this, 'plugin_' + pluginName)) {
                    $.data(this, 'plugin_' + pluginName,
                            new Plugin(this, options));
                }
            });
        }

    })(jQuery, window, document);
</script>

      <script type="text/javascript" src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script type="text/javascript" src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<script type="text/javascript">
    function my()
    {
         $('.customdrop').addClass('cusomclass');
        $('.dropmenu').toggle();
       
    }
</script>
</body>
</html>



<!--            <div class="modal fade" id="login-modalclient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog">
                          
                                <div class="loginmodal-container">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h1> Client Login Area </h1><br>
                                  <form>
                                        <input type="text" name="user" placeholder="Enter Your Account ID ">
                                        <input type="password" name="pass" placeholder="Enter Your Password">
                                        <input type="submit" name="login" class="login loginmodal-submit" value="Login">
                                    </form>
                                </div>
                          </div>
                    </div>-->

<div class="modal fade" id="login-modal01" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">

        <div class="loginmodal-container">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h1> Linguists Login Area</h1><br>
            <form>
                <input type="text" name="user" placeholder="Enter Your UserName (Email Address) ">
                <input type="password" name="pass" placeholder="Enter Your Password">
                <input type="submit" name="login" class="login loginmodal-submit" value="Login">
            </form>
            <div class="login-help">
                <a href="#"> Forgot Password</a>  /  <a href="resigtration.php" style="color:blue;font-size:15px;"> New User </a> 
            </div>
        </div>
    </div>
</div>


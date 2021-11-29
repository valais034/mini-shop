<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>

<!-- Page Content -->
<div class="container">

    <div class="row">
        <h4 class="text-center bg-danger"><?php display_message(); ?></h4>
        <h1>صورت حساب</h1>

        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_cart">
            <input type="hidden" name="business" value="edwindiaz123-facilitator@gmail.com">
            <input type="hidden" name="currency_code" value="US">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>محصول</th>
                    <th>قیمت</th>
                    <th>تعداد</th>
                    <th>قیمت نهایی</th>
                </tr>
                </thead>
                <tbody>
                <?php cart(); ?>
                </tbody>
            </table>
        </form>


        <!--  ***********CART TOTALS*************-->

        <div class="col-xs-4 pull-right ">
            <h2>اطلاعات سبد</h2>
            <table class="table table-bordered" cellspacing="0">
                <tr class="cart-subtotal">
                    <th>تعداد :</th>
                    <td>
                        <span class="amount"><?php
                            echo isset($_SESSION['item_quantity']) ? $_SESSION['item_quantity'] : $_SESSION['item_quantity'] = "0"; ?>
                        </span>
                    </td>
                </tr>
                <tr class="shipping">
                    <th>بسته بندی و ارسال</th>
                    <td>رایگان</td>
                </tr>

                <tr class="order-total">
                    <th>جمع قیمت فاکتور :</th>
                    <td><strong>
                            <span class="amount">
                                <?php echo isset($_SESSION['item_total']) ? $_SESSION['item_total'] : $_SESSION['item_total'] = "0"; ?>
                            </span>
                        </strong></td>
                </tr>
                </tbody>
            </table>
        </div><!-- CART TOTALS-->
    </div>
    <!--Buying Process-->
    <?php  if (countFinalPrice() != 0) { ?>
        <a href="#" id="purches" class="btn btn-success">تایید فاکتور و پرداخت</a>
    <?php } else { ?>
        <a href="#" id="" class="btn btn-danger">سبد شما خالی است</a>
    <?php } ?>
    <!-- jQuery -->


    <script src="js/jquery.js"></script>
    <script>
        $(document).ready(function () {
            $("#purches").click(function () {
                $.ajax({
                    type: "GET",
                    url: "../resources/request.php",
                    datatype: "json",
                    success: function (response) {
                        Zarinak.setAuthority(response.Authority);
                        Zarinak.open();
                        Zarinak.setCallBack(function (au, status) {
                            if(status == "OK"){
                                alert("پرداخت انجام شد :دی")
                            }else{
                                alert("پرداخت انجام نشد :|")
                            }
                        });
                    }
                });
            });
        });
    </script>

</div>
<!-- /.container -->


<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>

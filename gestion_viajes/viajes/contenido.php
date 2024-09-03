<?php
function select($id, $nombre, $options = [])
{
    ob_start(); // Iniciar el almacenamiento en búfer

?>
    <div class="col-sm-6">
        <!-- Form -->
        <div class="mb-4">
            <label for="<?php echo htmlspecialchars($id); ?>" class="form-label"><?php echo htmlspecialchars($nombre); ?></label>
            <select class="form-select form-select-sm" name="<?php echo htmlspecialchars($id); ?>" id="<?php echo htmlspecialchars($id); ?>">
                <?php
                foreach ($options as $value => $text) {
                    echo '<option value="' . htmlspecialchars($value) . '">' . htmlspecialchars($text) . '</option>';
                }
                ?>
            </select>
        </div>
        <!-- End Form -->
    </div>
<?php

    $html = ob_get_clean(); // Capturar el contenido del búfer y limpiarlo
    return $html;
}
?>

<main id="content" role="main" class="main">
    <!-- Content -->
    <div class="content container-fluid">
        <!-- Step Form -->
        <form class="js-step-form" data-hs-step-form-options='{
              "progressSelector": "#checkoutStepFormProgress",
              "stepsSelector": "#checkoutStepFormContent",
              "endSelector": "#checkoutFinishBtn",
              "isValidate": false
            }'>
            <!-- Content Step Form -->
            <div class="row">
                <div class="col-lg-4 order-lg-2 mb-5 mb-lg-0">
                    <div id="checkoutStepOrderSummary">
                        <!-- Card -->
                        <div class="card mb-3">
                            <!-- Header -->
                            <div class="card-header card-header-content-between">
                                <h4 class="card-header-title">2 item</h4>
                                <a href="#">Edit</a>
                            </div>
                            <!-- End Header -->

                            <!-- Body -->

                            <!-- Body -->
                        </div>
                        <!-- End Card -->

                        <!-- Help Link -->
                        <div class="d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="bi-headset"></i>
                                </div>

                                <div class="flex-grow-1 ms-2">
                                    <span class="fw-semibold me-1">Need Help?</span>
                                    <a class="link" href="#">Contact us</a>
                                </div>
                            </div>
                        </div>
                        <!-- End Help Link -->
                    </div>
                </div>
                <!-- End Col -->

                <div class="col-lg-8">

                    <h1 class="mb-5">V-59599</h1>

                    <div id="checkoutStepFormContent">
                        <!-- Card -->
                        <div id="checkoutStepDelivery" class="active">
                            <div class="card mb-3 mb-lg-5">
                                <!-- Header -->
                                <div class="card-header">
                                    <h4 class="card-header-title">Delivery details</h4>
                                </div>
                                <!-- End Header -->

                                <!-- Body -->
                                <div class="card-body">
                                    <div class="row">
                                        <?php
                                        echo select('id_vehiculo', 'Vehiculo');
                                        echo select('id_vehiculo', 'Fecha');
                                        echo select('id_vehiculo', 'Remolque 1');
                                        echo select('id_vehiculo', 'Ruta');
                                        echo select('id_vehiculo', 'Dolly');
                                        echo select('id_vehiculo', 'Origen');
                                        echo select('id_vehiculo', 'Remolque 2');
                                        echo select('id_vehiculo', 'Destino');
                                        echo select('id_vehiculo', 'Conductor');
                                        echo select('id_vehiculo', 'Ejecutivo');
                                        echo select('id_vehiculo', 'Motogenerador 1');
                                        echo select('id_vehiculo', 'Motogenerador 2');
                                        echo select('id_vehiculo', 'Ejecutivo');
                                        ?>
                                    </div>
                                    <!-- End Row -->
                                </div>
                                <!-- Body -->
                            </div>
                            <!-- End Card -->
                        </div>

                        <div id="checkoutStepPayment" style="display: none;">
                            <!-- Card -->
                            <div class="card mb-3 mb-lg-5">
                                <!-- Header -->
                                <div class="card-header">
                                    <h4 class="card-header-title">Payment method</h4>
                                </div>
                                <!-- End Header -->

                                <!-- Body -->
                                <div class="card-body">
                                    <!-- Radio Button Group -->
                                    <div class="btn-group-sm-vertical">
                                        <div class="btn-group btn-group-segment btn-group-fill mb-4" role="group" aria-label="Status radio button group">
                                            <input type="radio" class="btn-check flex-fill" name="ecommerceCheckoutBtnRadio" id="ecommerceCheckoutBtnRadioCreditCard" autocomplete="off" checked>
                                            <label class="btn btn-sm" for="ecommerceCheckoutBtnRadioCreditCard">
                                                <img class="avatar avatar-xss avatar-4x3 me-2" src="./assets/svg/brands/mastercard.svg" alt="Image Description">
                                                Credit or Debit card
                                            </label>

                                            <input type="radio" class="btn-check flex-fill" name="ecommerceCheckoutBtnRadio" id="ecommerceCheckoutBtnRadioPayPal" autocomplete="off" disabled>
                                            <label class="btn btn-sm" for="ecommerceCheckoutBtnRadioPayPal">
                                                <img class="avatar avatar-xss avatar-4x3 me-2" src="./assets/svg/brands/paypal-icon.svg" alt="Image Description">
                                                PayPal <span class="badge bg-soft-primary text-primary">Coming soon</span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- End Radio Button Group -->

                                    <!-- Form -->
                                    <div class="mb-4">
                                        <label for="cardNameLabel" class="form-label">Name on card</label>
                                        <input type="text" class="form-control" id="cardNameLabel" placeholder="Payoneer" aria-label="Payoneer">
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div class="mb-4">
                                        <label for="cardNumberLabel" class="form-label">Card number</label>
                                        <input type="text" class="js-input-mask form-control" name="cardNumber" id="cardNumberLabel" placeholder="xxxx xxxx xxxx xxxx" aria-label="xxxx xxxx xxxx xxxx" data-hs-mask-options='{
                              "mask": "0000 0000 0000 0000"
                            }'>
                                    </div>
                                    <!-- End Form -->

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- Form -->
                                            <div class="mb-4">
                                                <label for="expirationDateLabel" class="form-label">Expiration date</label>
                                                <input type="text" class="js-input-mask form-control" name="expirationDate" id="expirationDateLabel" placeholder="xx/xxxx" aria-label="xx/xxxx" data-hs-mask-options='{
                                  "mask": "00/0000"
                                }'>
                                            </div>
                                            <!-- End Form -->
                                        </div>

                                        <div class="col-sm-6">
                                            <!-- Form -->
                                            <div class="mb-4">
                                                <label for="securityCodeLabel" class="form-label">CVV Code <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="A 3 - digit number, typically printed on the back of a card."></i></label>
                                                <input type="text" class="js-input-mask form-control" name="securityCode" id="securityCodeLabel" placeholder="xxx" aria-label="xxx" data-hs-mask-options='{
                                  "mask": "000"
                                }'>
                                            </div>
                                            <!-- End Form -->
                                        </div>
                                    </div>
                                    <!-- End Row -->

                                    <div class="d-grid gap-2">
                                        <!-- Form Check -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="makePrimaryCheckbox1">
                                            <label class="form-check-label" for="makePrimaryCheckbox1">
                                                Make this primary card
                                            </label>
                                        </div>
                                        <!-- End Form Check -->

                                        <!-- Form Check -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="saveCardCheckbox1">
                                            <label class="form-check-label" for="saveCardCheckbox1">
                                                Save my payment details for future purchases
                                            </label>
                                        </div>
                                        <!-- End Form Check -->
                                    </div>
                                </div>
                                <!-- Body -->
                            </div>
                            <!-- End Card -->

                            <!-- Footer -->
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-ghost-secondary" data-hs-step-form-next-options='{
                            "targetSelector": "#checkoutStepDelivery"
                          }'>
                                    <i class="bi-chevron-left"></i> Return to Delivery
                                </button>
                                <div class="ms-auto">
                                    <button type="button" class="btn btn-primary" data-hs-step-form-next-options='{
                              "targetSelector": "#checkoutStepSummary"
                            }'>
                                        Continue <i class="bi-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- End Footer -->
                        </div>

                        <div id="checkoutStepSummary" style="display: none;">
                            <!-- Card -->
                            <div class="card mb-3 mb-lg-5">
                                <!-- Header -->
                                <div class="card-header">
                                    <h4 class="card-header-title">Order summary</h4>
                                </div>
                                <!-- End Header -->

                                <!-- Body -->
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5>Billing address</h5>
                                        <a class="link" href="javascript:;">Edit</a>
                                    </div>

                                    <span class="d-block">
                                        Anne Richard,<br>
                                        anne@gmail.com,<br>
                                        +1 (609) 972-22-22,<br>
                                        45 Roker Terrace,<br>
                                        Latheronwheel,<br>
                                        KW5 8NW, London,<br>
                                        UK <img class="avatar avatar-xss avatar-circle ms-1" src="./assets/vendor/flag-icon-css/flags/1x1/gb.svg" alt="Great Britain Flag">
                                    </span>

                                    <hr>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Delivery option</h5>
                                        <a class="link" href="javascript:;">Edit</a>
                                    </div>

                                    <span class="d-block">Standard delivery</span>

                                    <hr>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5>Payment method</h5>
                                        <a class="link" href="javascript:;">Edit</a>
                                    </div>

                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <img class="avatar avatar-sm avatar-4x3" src="./assets/svg/brands/mastercard.svg" alt="Image Description">
                                        </div>

                                        <div class="flex-grow-1 ms-3">
                                            <span class="d-block text-dark">MasterCard &bull;&bull;&bull;&bull; 4242</span>
                                            <small class="d-block text-muted">Checking - Expires 12/22</small>
                                        </div>
                                    </div>
                                </div>
                                <!-- Body -->
                            </div>
                            <!-- End Card -->

                            <!-- Footer -->
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-ghost-secondary" data-hs-step-form-next-options='{
                            "targetSelector": "#checkoutStepPayment"
                          }'>
                                    <i class="bi-chevron-left"></i> Return to Payment
                                </button>
                                <div class="ms-auto">
                                    <button id="checkoutFinishBtn" type="button" class="btn btn-primary">Place order</button>
                                </div>
                            </div>
                            <!-- End Footer -->
                        </div>
                    </div>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Step Form -->
        </form>
        <!-- End Step Form -->

        <!-- Message Body -->
        <div id="checkoutStepSuccessMessage" style="display: none;">
            <div class="text-center">
                <img class="img-fluid mb-3" src="./assets/svg/illustrations/oc-hi-five.svg" alt="Image Description" data-hs-theme-appearance="default" style="max-width: 15rem;">
                <img class="img-fluid mb-3" src="./assets/svg/illustrations-light/oc-hi-five.svg" alt="Image Description" data-hs-theme-appearance="dark" style="max-width: 15rem;">

                <div class="mb-4">
                    <h2>Your payment was successful!</h2>
                    <p>Order #72712</p>
                    <p>You will receive an email confirmation.</p>
                </div>

                <a class="btn btn-primary" href="./ecommerce.html">
                    <i class="bi-basket me-1"></i> Continue shopping
                </a>
            </div>
        </div>
        <!-- End Message Body -->
    </div>
    <!-- End Content -->
</main>
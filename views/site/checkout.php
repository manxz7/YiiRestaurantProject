<?php

/** @var yii\web\View $this */
/** @var app\models\Booking $model */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Checkout';
?>
<section style="padding: 80px 0; min-height: 60vh;">
    <div class="container">
        <h2 style="text-align:center; margin-bottom: 10px;">Checkout</h2>
        <p style="text-align:center; color:#999; margin-bottom: 40px;">Review your order and fill in booking details</p>

        <div class="row">
            <div class="col-lg-7">
                <div style="background:white; border-radius:12px; padding:30px; box-shadow:0 2px 15px rgba(0,0,0,0.08); margin-bottom:20px;">
                    <h5 style="margin-bottom:20px; border-bottom:2px solid #ce1212; padding-bottom:10px;">Booking Details</h5>

                    <?php $form = ActiveForm::begin(['id' => 'checkout-form']); ?>
                    <?= Html::hiddenInput('cart_data', '', ['id' => 'cart_data']) ?>
                    <?= Html::hiddenInput('total_price', '', ['id' => 'total_price_input']) ?>

                    <div class="row gy-3">
                        <div class="col-md-6">
                            <?= $form->field($model, 'name')->textInput(['placeholder' => 'Full name']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Phone number']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'people')->input('number', ['min' => 1, 'placeholder' => 'Number of people']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'date')->input('date') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'time')->input('time') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'message')->textarea(['rows' => 3, 'placeholder' => 'Additional note']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>

                <div style="background:white; border-radius:12px; padding:30px; box-shadow:0 2px 15px rgba(0,0,0,0.08);">
                    <h5 style="margin-bottom:20px; border-bottom:2px solid #ce1212; padding-bottom:10px;">Payment Information</h5>

                    <div style="background:#f8f9fa; border-radius:8px; padding:20px; margin-bottom:15px;">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:15px;">
                            <span style="font-size:24px;">Card</span>
                            <strong>Credit / Debit Card</strong>
                        </div>
                        <div class="row gy-3">
                            <div class="col-12">
                                <label style="font-weight:600; margin-bottom:5px; display:block;">Card Number</label>
                                <input type="text" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19" oninput="formatCard(this)">
                            </div>
                            <div class="col-md-6">
                                <label style="font-weight:600; margin-bottom:5px; display:block;">Expiry</label>
                                <input type="text" class="form-control" placeholder="MM/YY" maxlength="5">
                            </div>
                            <div class="col-md-6">
                                <label style="font-weight:600; margin-bottom:5px; display:block;">CVV</label>
                                <input type="text" class="form-control" placeholder="123" maxlength="3">
                            </div>
                        </div>
                    </div>

                    <p style="color:#999; font-size:12px; text-align:center;">This is a demo payment section. No real payment is charged.</p>
                </div>
            </div>

            <div class="col-lg-5">
                <div style="background:white; border-radius:12px; padding:30px; box-shadow:0 2px 15px rgba(0,0,0,0.08); position:sticky; top:100px;">
                    <h5 style="margin-bottom:20px; border-bottom:2px solid #ce1212; padding-bottom:10px;">Order Summary</h5>

                    <div id="checkout-items" style="margin-bottom:15px;"></div>

                    <div style="border-top:2px solid #eee; padding-top:15px; margin-bottom:20px;">
                        <div style="display:flex; justify-content:space-between; font-size:14px; color:#666; margin-bottom:8px;">
                            <span>Subtotal</span>
                            <span>RM <span id="subtotal">0.00</span></span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:14px; color:#666; margin-bottom:8px;">
                            <span>Service Charge (0%)</span>
                            <span>RM 0.00</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:18px; font-weight:bold; margin-top:10px;">
                            <span>Total</span>
                            <span style="color:#ce1212;">RM <span id="checkout-total">0.00</span></span>
                        </div>
                    </div>

                    <button onclick="submitOrder()" style="
                        display:block;
                        width:100%;
                        background:#ce1212;
                        color:white;
                        border:none;
                        padding:16px;
                        border-radius:8px;
                        font-size:16px;
                        font-weight:bold;
                        cursor:pointer;
                        transition: background 0.3s;
                    " onmouseover="this.style.background='#a50e0e'" onmouseout="this.style.background='#ce1212'">
                        Confirm and Pay
                    </button>

                    <a href="<?= Html::encode(Url::to(['/site/cart'])) ?>" style="display:block; text-align:center; margin-top:15px; color:#999; font-size:14px;">
                        Back to Cart
                    </a>

                    <div id="empty-warning" style="display:none; background:#fff3cd; border-radius:8px; padding:15px; margin-top:15px; text-align:center; color:#856404;">
                        Cart is empty. Please add menu items first.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    if (cart.length === 0) {
        document.getElementById('empty-warning').style.display = 'block';
        document.getElementById('checkout-items').innerHTML = '<p style="color:#999; text-align:center;">No items in cart.</p>';
        return;
    }

    let itemsHTML = '';
    let total = 0;

    cart.forEach(item => {
        const subtotal = item.price * item.qty;
        total += subtotal;

        itemsHTML += `
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px; padding-bottom:12px; border-bottom:1px solid #f0f0f0;">
            <img src="/yummy-red/img/menu/${item.image}" style="width:50px; height:50px; object-fit:cover; border-radius:6px;"
                 onerror="this.src='/yummy-red/img/menu/menu-item-1.png'">
            <div style="flex:1;">
                <div style="font-weight:600; font-size:14px;">${item.name}</div>
                <div style="color:#999; font-size:13px;">x${item.qty}</div>
            </div>
            <div style="font-weight:bold; color:#ce1212;">RM ${subtotal.toFixed(2)}</div>
        </div>`;
    });

    document.getElementById('checkout-items').innerHTML = itemsHTML;
    document.getElementById('subtotal').textContent = total.toFixed(2);
    document.getElementById('checkout-total').textContent = total.toFixed(2);
    document.getElementById('cart_data').value = JSON.stringify(cart);
    document.getElementById('total_price_input').value = total.toFixed(2);
});

function formatCard(input) {
    let value = input.value.replace(/\D/g, '');
    value = value.replace(/(.{4})/g, '$1 ').trim();
    input.value = value;
}

function submitOrder() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    if (cart.length === 0) {
        alert('Cart is empty. Please add menu items first.');
        return;
    }

    document.getElementById('checkout-form').submit();
}
</script>

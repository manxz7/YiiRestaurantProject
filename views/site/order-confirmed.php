<?php

/** @var yii\web\View $this */
/** @var app\models\Booking $booking */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Order Confirmed';
?>
<section style="padding: 80px 0; min-height: 70vh;">
    <div class="container">
        <div style="max-width:600px; margin:0 auto; text-align:center;">
            <div style="
                width:100px; height:100px;
                border: 4px solid #28a745;
                border-radius:50%;
                display:flex;
                align-items:center;
                justify-content:center;
                margin: 0 auto 30px;
                font-size:50px;
                color:#28a745;
            ">OK</div>

            <h2 style="font-weight:bold; margin-bottom:10px;">Order Confirmed!</h2>
            <p style="color:#666; font-size:16px; margin-bottom:30px;">
                Thank you, <strong><?= Html::encode($booking->name) ?></strong>! Your booking has been confirmed.
            </p>

            <div style="background:white; border-radius:12px; padding:30px; box-shadow:0 2px 15px rgba(0,0,0,0.08); text-align:left; margin-bottom:30px;">
                <h5 style="border-bottom:2px solid #ce1212; padding-bottom:10px; margin-bottom:20px;">Booking Details</h5>

                <table style="width:100%; border-collapse:collapse;">
                    <tr style="border-bottom:1px solid #f0f0f0;"><td style="padding:10px 0; color:#666; width:40%;">Booking ID</td><td style="padding:10px 0; font-weight:bold;">#<?= Html::encode(str_pad((string) $booking->id, 4, '0', STR_PAD_LEFT)) ?></td></tr>
                    <tr style="border-bottom:1px solid #f0f0f0;"><td style="padding:10px 0; color:#666;">Name</td><td style="padding:10px 0; font-weight:bold;"><?= Html::encode($booking->name) ?></td></tr>
                    <tr style="border-bottom:1px solid #f0f0f0;"><td style="padding:10px 0; color:#666;">Email</td><td style="padding:10px 0;"><?= Html::encode($booking->email) ?></td></tr>
                    <tr style="border-bottom:1px solid #f0f0f0;"><td style="padding:10px 0; color:#666;">Phone</td><td style="padding:10px 0;"><?= Html::encode($booking->phone) ?></td></tr>
                    <tr style="border-bottom:1px solid #f0f0f0;"><td style="padding:10px 0; color:#666;">Date</td><td style="padding:10px 0;"><?= Html::encode(Yii::$app->formatter->asDate($booking->date, 'php:d M Y')) ?></td></tr>
                    <tr style="border-bottom:1px solid #f0f0f0;"><td style="padding:10px 0; color:#666;">Time</td><td style="padding:10px 0;"><?= Html::encode(Yii::$app->formatter->asTime($booking->time, 'php:h:i A')) ?></td></tr>
                    <tr style="border-bottom:1px solid #f0f0f0;"><td style="padding:10px 0; color:#666;">People</td><td style="padding:10px 0;"><?= Html::encode((string) $booking->people) ?> people</td></tr>
                    <tr><td style="padding:10px 0; color:#666;">Status</td><td style="padding:10px 0;"><span style="background:#d4edda; color:#155724; padding:4px 12px; border-radius:20px; font-size:13px; font-weight:bold;">Confirmed</span></td></tr>
                </table>
            </div>

            <div style="background:white; border-radius:12px; padding:30px; box-shadow:0 2px 15px rgba(0,0,0,0.08); text-align:left; margin-bottom:30px;">
                <h5 style="border-bottom:2px solid #ce1212; padding-bottom:10px; margin-bottom:20px;">Order Items</h5>
                <div id="confirmed-items">
                    <p style="color:#999; text-align:center;">Loading order...</p>
                </div>
                <div style="border-top:2px solid #eee; padding-top:15px; margin-top:10px; text-align:right;">
                    <strong style="font-size:16px;">Total: <span style="color:#ce1212;">RM <span id="confirmed-total">0.00</span></span></strong>
                </div>
            </div>

            <div style="background:#d4edda; border-radius:12px; padding:20px; margin-bottom:30px;">
                <p style="margin:0; color:#155724; font-weight:bold;">
                    Payment Status: <span style="background:#28a745; color:white; padding:2px 10px; border-radius:10px;">PAID</span>
                </p>
            </div>

            <div style="display:flex; gap:15px; justify-content:center; flex-wrap:wrap;">
                <a href="<?= Html::encode(Url::to(['/site/index'])) ?>" style="background:#ce1212; color:white; padding:12px 30px; border-radius:8px; text-decoration:none; font-weight:bold;">
                    Back to Home
                </a>
                <a href="<?= Html::encode(Url::to(['/site/index', '#' => 'menu'])) ?>" style="background:white; color:#ce1212; padding:12px 30px; border-radius:8px; text-decoration:none; font-weight:bold; border:2px solid #ce1212;">
                    View Menu Again
                </a>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    if (cart.length === 0) {
        document.getElementById('confirmed-items').innerHTML = '<p style="color:#999; text-align:center;">No order record in browser cart.</p>';
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
                <div style="font-weight:600;">${item.name}</div>
                <div style="color:#999; font-size:13px;">x${item.qty} × RM${item.price.toFixed(2)}</div>
            </div>
            <div style="font-weight:bold;">RM ${subtotal.toFixed(2)}</div>
        </div>`;
    });

    document.getElementById('confirmed-items').innerHTML = itemsHTML;
    document.getElementById('confirmed-total').textContent = total.toFixed(2);

    localStorage.removeItem('cart');
    updateCartCount();
});
</script>

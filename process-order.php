<?php 
// Define variables
$customerName = isset($_POST['customerName']) ? $_POST['customerName'] : "";
$membership = isset($_POST['membership']) ? $_POST['membership'] : "";
$yoga = isset($_POST['yoga']) ? $_POST['yoga'] : "";
$zumba = isset($_POST['zumba']) ? $_POST['zumba'] : "";
$personalTrainer = isset($_POST['personalTrainer']) ? $_POST['personalTrainer'] : "";
$membershipDuration = isset($_POST['membershipDuration']) ? (int) $_POST['membershipDuration'] : 0;

// 2. Define constants
define('ADULT', 40);
define('STUDENT', 30);
define('SENIOR', 25);

define('YOGA', 10);
define('ZUMBA', 15);
define('PTRAINER', 50);

// 3. Membership base fee
switch ($membership) {
  case 'adult':
    $monthlyFee = ADULT;
    break;
  case 'student':
    $monthlyFee = STUDENT;
    break;
  case 'senior':
    $monthlyFee = SENIOR;
    break;
  default:
    $monthlyFee = 0;
    break;
}

// 4. Add-ons
if($yoga) $monthlyFee += YOGA; 
if($zumba) $monthlyFee += ZUMBA; 
if($personalTrainer) $monthlyFee += PTRAINER;

// 5. Discount logic 
$discountPercent = 0;
if($discountPercent >= 6 && $membershipDuration < 12) { 
  $discountPercent = 0.10; 
} else if ($membershipDuration >= 12) {
  $discountPercent = 0.15; 
}

// 6. Calculate totals
$subtotal = $monthlyFee * $membershipDuration;
$discount = $discountPercent * $subtotal;
$total = $subtotal - $discount;

// 7. Currency formatter
function FormatCurrency($num) {
  return '$'. number_format($num, 2);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Premium Fitness Club – Order Summary</title>
</head>
<body>
  <div>
    <h2>Premium Fitness Club – Order Summary</h2>

    <div class="section1">
      <p>Customer Name: <?= htmlspecialchars($customerName) ?></p>
      <p>Membership: <?= htmlspecialchars($membership) ?></p>
      <p>Duration: <?= htmlspecialchars($membershipDuration) ?> months</p><br>

      <p>Optional Services: </p>
      <ul>
        <?php if ($yoga): ?>
          <li>Yoga ($10/month)</li>
        <?php endif; ?>

        <?php if($zumba): ?>
          <li>Zumba ($15/month)</li>
        <?php endif; ?> 

        <?php if($personalTrainer): ?>
          <li>Personal Trainer ($50/month)</li>
        <?php endif; ?> 

        <?php if(!$yoga && !$zumba && !$personalTrainer): ?>
          <li>None</li>
        <?php endif; ?><br>
      </ul>
    </div>

    <div class="section2">
      <p>Monthly Fee: <?= FormatCurrency($monthlyFee) ?></p>
      <p>Subtotal: <?= FormatCurrency($subtotal) ?></p>    
      <p>Discount (<?= FormatCurrency($discountPercent) ?>): -<?= FormatCurrency($discount) ?></p>
      </p>
    </div>

    <div class="section3">
      <p>Total: <?= FormatCurrency($total) ?></p>
    </div>

    <a href="order-form.html" class="back-btn">
      <button>← Back to Calculator</button>
    </a>
  </div>
</body>
</html>


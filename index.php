<?php 
header('Content-type: text/html; charset=UTF-8') ;
srand();
require_once('common.php');
require_once('data/armor.php');
require_once('data/materials.php');
require_once('data/names.php');
require_once('data/potions.php');
require_once('data/rings.php');
require_once('data/scrolls.php');
require_once('data/staves.php');
require_once('data/wands.php');
require_once('data/weapons.php');
require_once('data/wondrous.php');
require_once('armor.php');
require_once('misc-items.php');
require_once('weapons.php');
require_once('wondrous.php');

if (isset($_POST['submit']))
{
    $c = intval($_POST['num_items']);
    $armor_bit = isset($_POST['armor_bit']);
    $potion_bit = isset($_POST['potion_bit']);
    $ring_bit = isset($_POST['ring_bit']);
    $scroll_bit = isset($_POST['scroll_bit']);
    $staff_bit = isset($_POST['staff_bit']);
    $wand_bit = isset($_POST['wand_bit']);
    $weapon_bit = isset($_POST['weapon_bit']);
    $wondrous_bit = isset($_POST['wondrous_bit']);
    $elvl = intval($_POST['elvl']);
    $total = intval($_POST['total']);
    $method = $_POST['method'];
}
else
{
    $c = 5;
    $armor_bit = true;
    $potion_bit = false;
    $ring_bit = true;
    $scroll_bit = false;
    $staff_bit = false;
    $wand_bit = true;
    $weapon_bit = true;
    $wondrous_bit = true;
    $elvl = 3;
    $total = 10000;
    $method = 'number';
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Alchemetris Loot Roller</title>
    <link rel="stylesheet" href="default.css">
</head>

<body>
    <h1>Alchemetris Loot Roller</h1>
<form action="index.php" method="POST">
<p>
    <input type="radio" name="method" value="number" <?php schecked($method === 'number'); ?>> # of items: <select name="num_items">
<?php
    for ($i = 1; $i < 11; $i++)
    {
        makeopt($i, $i, $c === $i);
    }
?>
    </select><br>
    <input type="radio" name="method" value="total" <?php schecked($method === 'total'); ?>> Total value: <select name="total">
<?php
    makeopt('5000', '5,000 gp', $total === 5000);
    makeopt('10000', '10,000 gp', $total === 10000);
    makeopt('25000', '25,000 gp', $total === 25000);
    makeopt('50000', '50,000 gp', $total === 50000);
    makeopt('100000', '100,000 gp', $total === 100000);
    makeopt('250000', '250,000 gp', $total === 250000);
    makeopt('500000', '500,000 gp', $total === 500000);
?>
    </select><br>
    For level: <select name="elvl">
<?php
    for ($i = 1; $i < 21; $i++)
    {
        makeopt($i, $i, $elvl === $i);
    }
?>
    </select>
</p>
<p>
    <input type="checkbox" name="armor_bit" <?php schecked($armor_bit); ?>> Armor<br>
    <input type="checkbox" name="potion_bit" <?php schecked($potion_bit); ?>> Potion<br>
    <input type="checkbox" name="ring_bit" <?php schecked($ring_bit); ?>> Ring<br>
    <input type="checkbox" name="scroll_bit" <?php schecked($scroll_bit); ?>> Scrolls<br>
    <input type="checkbox" name="staff_bit" <?php schecked($staff_bit); ?>> Staves<br>
    <input type="checkbox" name="wand_bit" <?php schecked($wand_bit); ?>> Wands<br>
    <input type="checkbox" name="weapon_bit" <?php schecked($weapon_bit); ?>> Weapons<br>
    <input type="checkbox" name="wondrous_bit" <?php schecked($wondrous_bit); ?>> Wondrous Items
</p>
<p>
    <input type="submit" name="submit" value="OK">
</p>
<?php
if (isset($_POST['submit']))
{
    $items = [];
    $itemfuncs = [];
    if ($armor_bit)
        array_push($itemfuncs, 'roll_armor');
    if ($potion_bit)
        array_push($itemfuncs, 'roll_potion');
    if ($ring_bit)
        array_push($itemfuncs, 'roll_ring');
    if ($scroll_bit)
        array_push($itemfuncs, 'roll_scroll');
    if ($staff_bit)
        array_push($itemfuncs, 'roll_staff');
    if ($wand_bit)
        array_push($itemfuncs, 'roll_wand');
    if ($weapon_bit)
        array_push($itemfuncs, 'roll_weapon');
    if ($wondrous_bit)
        array_push($itemfuncs, 'roll_wondrous');
    if (count($itemfuncs) === 0)
        die('No item types');
    $top = $wealth[$elvl];
    $bottom = $elvl < 5 ? 0 : $top / 2;
    if ($method === 'number')
    {
        for ($i = 0; $i < $c; $i++)
        {
            $func = arr($itemfuncs);
            $item = call_user_func($func, $bottom, $top);
            array_push($items, $item);
        }
    }
    else
    {
        $rolled = 0;
        while ($rolled < $total)
        {
            $func = arr($itemfuncs);
            $item = call_user_func($func, $bottom, $top);
            if (($item->cost + $rolled) > ($total * 1.10))
                continue;
            array_push($items, $item);
            $rolled += $item->cost;
        }
    }
foreach ($items as $w)
{
    $rarity = item_rarity($w->enh, $w->cost);
?>
    <div class="item-detail-template item-rarity-<?php echo $rarity; ?>">
        <div class="item-icon <?php echo $w->icon; ?>"></div>
        <div class="item-name">
<?php
    if (isset($w->name))
    {
        echo $w->name;
    }
    else if (strpos($w->desc, '(') !== FALSE)
    {
        echo substr($w->desc, 0, strpos($w->desc, '('));
    }
    if ($w->enh > 0)
    {
        echo ' +' . $w->enh;
    }
?>
        </div>
        <p class="item-type"><?php echo $rarity . ' ' . $w->desc; ?></p>

        <div class="stats">
            <p class="attributes">
<?php
    foreach ($w->tags as $tag)
    {
?>
                <span class="attribute"><?php echo $tag; ?></span>
<?php
    }
?>
            </p>
        </div>

        <p class="item-value"><span class="item-value-gold"><?php echo number_format($w->cost); ?></span></p>
    </div>
<?php 
    }
}
?>
</form>
</body>

</html>
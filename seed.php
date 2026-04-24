<?php
/**
 * Sample Data Seeder
 * Run: php seed.php
 * Inserts 5 restaurants, menu items, 3 users with addresses, 20 orders
 */

define('ROOT_DIR', __DIR__);
require_once ROOT_DIR . '/vendor/autoload.php';
require_once ROOT_DIR . '/config/config.php';
require_once ROOT_DIR . '/config/database.php';
require_once ROOT_DIR . '/config/redis.php';

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

$db    = Database::getInstance()->getDB();
$redis = RedisClient::getInstance();

echo "🌱 FoodRush Seeder Starting...\n\n";

// ─── Drop existing data ───────────────────────────────────────────────────────
$db->selectCollection('restaurants')->drop();
$db->selectCollection('users')->drop();
$db->selectCollection('orders')->drop();
$db->selectCollection('reviews')->drop();
echo "✓ Cleared old data\n";

// ─── Helper ───────────────────────────────────────────────────────────────────
function ts(string $offset = 'now'): UTCDateTime {
    return new UTCDateTime(new DateTime($offset));
}

// ─── 1. Restaurants ───────────────────────────────────────────────────────────
$restaurants = [
    [
        'name' => 'Spice Garden',
        'email' => 'spice@example.com',
        'password' => password_hash('password123', PASSWORD_BCRYPT),
        'owner_id' => 'owner_1',
        'phone' => '9876543210',
        'address' => '12 MG Road',
        'city' => 'Bangalore',
        'cuisine' => ['Indian', 'North Indian', 'Biryani'],
        'description' => 'Authentic North Indian cuisine with rich gravies and aromatic biryanis.',
        'image' => 'default_restaurant.jpg',
        'is_veg' => false,
        'opens_at' => '10:00', 'closes_at' => '23:00',
        'delivery_fee' => 30, 'min_order' => 150,
        'total_orders' => 342, 'avg_rating' => 4.3, 'total_revenue' => 185600.0,
        'review_count' => 120, 'rating_sum' => 516.0,
        'is_active' => true,
        'created_at' => ts('-30 days'), 'updated_at' => ts(),
        'menu_items' => [
            ['_id'=>new ObjectId(),'name'=>'Butter Chicken','price'=>320.0,'type'=>'non_veg','spice_level'=>'medium','is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Chicken Biryani','price'=>280.0,'type'=>'non_veg','spice_level'=>'high','is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Paneer Butter Masala','price'=>260.0,'type'=>'veg','is_jain'=>false,'is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Jain Dal Tadka','price'=>180.0,'type'=>'veg','is_jain'=>true,'is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Mango Lassi','price'=>80.0,'type'=>'beverage','serving_size_ml'=>350,'is_available'=>true,'created_at'=>ts()],
        ],
    ],
    [
        'name' => 'Dragon Palace',
        'email' => 'dragon@example.com',
        'password' => password_hash('password123', PASSWORD_BCRYPT),
        'owner_id' => 'owner_2',
        'phone' => '9876543211',
        'address' => '45 Linking Road',
        'city' => 'Mumbai',
        'cuisine' => ['Chinese', 'Asian', 'Thai'],
        'description' => 'Authentic Chinese and Pan-Asian cuisine in the heart of the city.',
        'image' => 'default_restaurant.jpg',
        'is_veg' => false,
        'opens_at' => '11:00', 'closes_at' => '22:30',
        'delivery_fee' => 40, 'min_order' => 200,
        'total_orders' => 218, 'avg_rating' => 4.1, 'total_revenue' => 124800.0,
        'review_count' => 85, 'rating_sum' => 348.5,
        'is_active' => true,
        'created_at' => ts('-25 days'), 'updated_at' => ts(),
        'menu_items' => [
            ['_id'=>new ObjectId(),'name'=>'Kung Pao Chicken','price'=>340.0,'type'=>'non_veg','spice_level'=>'high','is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Veg Hakka Noodles','price'=>220.0,'type'=>'veg','is_jain'=>false,'is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Dim Sum Basket','price'=>280.0,'type'=>'non_veg','spice_level'=>'low','is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Spring Rolls (Jain)','price'=>160.0,'type'=>'veg','is_jain'=>true,'is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Green Tea','price'=>60.0,'type'=>'beverage','serving_size_ml'=>200,'is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Thai Iced Tea','price'=>90.0,'type'=>'beverage','serving_size_ml'=>400,'is_available'=>true,'created_at'=>ts()],
        ],
    ],
    [
        'name' => 'Pizza Paradiso',
        'email' => 'pizza@example.com',
        'password' => password_hash('password123', PASSWORD_BCRYPT),
        'owner_id' => 'owner_3',
        'phone' => '9876543212',
        'address' => '7 Brigade Road',
        'city' => 'Bangalore',
        'cuisine' => ['Italian', 'Pizza', 'Fast Food'],
        'description' => 'Wood-fired Italian pizzas and fresh pastas made with imported ingredients.',
        'image' => 'default_restaurant.jpg',
        'is_veg' => false,
        'opens_at' => '11:00', 'closes_at' => '23:59',
        'delivery_fee' => 50, 'min_order' => 250,
        'total_orders' => 467, 'avg_rating' => 4.5, 'total_revenue' => 312400.0,
        'review_count' => 200, 'rating_sum' => 900.0,
        'is_active' => true,
        'created_at' => ts('-20 days'), 'updated_at' => ts(),
        'menu_items' => [
            ['_id'=>new ObjectId(),'name'=>'Margherita Pizza','price'=>320.0,'type'=>'veg','is_jain'=>false,'is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'BBQ Chicken Pizza','price'=>420.0,'type'=>'non_veg','spice_level'=>'medium','is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Penne Arrabbiata','price'=>280.0,'type'=>'veg','is_jain'=>false,'is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Pepperoni Pizza','price'=>460.0,'type'=>'non_veg','spice_level'=>'medium','is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Fresh Lemonade','price'=>80.0,'type'=>'beverage','serving_size_ml'=>300,'is_available'=>true,'created_at'=>ts()],
        ],
    ],
    [
        'name' => 'Green Leaf (100% Veg)',
        'email' => 'greenleaf@example.com',
        'password' => password_hash('password123', PASSWORD_BCRYPT),
        'owner_id' => 'owner_4',
        'phone' => '9876543213',
        'address' => '22 Anna Nagar',
        'city' => 'Chennai',
        'cuisine' => ['South Indian', 'Healthy', 'Vegan'],
        'description' => 'Pure vegetarian South Indian comfort food, Jain-friendly options available.',
        'image' => 'default_restaurant.jpg',
        'is_veg' => true,
        'opens_at' => '07:00', 'closes_at' => '22:00',
        'delivery_fee' => 20, 'min_order' => 100,
        'total_orders' => 589, 'avg_rating' => 4.6, 'total_revenue' => 198400.0,
        'review_count' => 230, 'rating_sum' => 1058.0,
        'is_active' => true,
        'created_at' => ts('-15 days'), 'updated_at' => ts(),
        'menu_items' => [
            ['_id'=>new ObjectId(),'name'=>'Masala Dosa','price'=>120.0,'type'=>'veg','is_jain'=>false,'is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Jain Idli Sambar','price'=>100.0,'type'=>'veg','is_jain'=>true,'is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Veg Thali','price'=>200.0,'type'=>'veg','is_jain'=>false,'is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Avocado Salad','price'=>180.0,'type'=>'veg','is_jain'=>true,'is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Filter Coffee','price'=>50.0,'type'=>'beverage','serving_size_ml'=>150,'is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Fresh Coconut Water','price'=>70.0,'type'=>'beverage','serving_size_ml'=>500,'is_available'=>true,'created_at'=>ts()],
        ],
    ],
    [
        'name' => 'Burger Barn',
        'email' => 'burger@example.com',
        'password' => password_hash('password123', PASSWORD_BCRYPT),
        'owner_id' => 'owner_5',
        'phone' => '9876543214',
        'address' => '88 Jubilee Hills',
        'city' => 'Hyderabad',
        'cuisine' => ['Fast Food', 'Burgers', 'American'],
        'description' => 'Gourmet burgers, crispy fries, and thick shakes for the bold and hungry.',
        'image' => 'default_restaurant.jpg',
        'is_veg' => false,
        'opens_at' => '11:00', 'closes_at' => '01:00',
        'delivery_fee' => 35, 'min_order' => 180,
        'total_orders' => 381, 'avg_rating' => 4.2, 'total_revenue' => 241600.0,
        'review_count' => 155, 'rating_sum' => 651.0,
        'is_active' => true,
        'created_at' => ts('-10 days'), 'updated_at' => ts(),
        'menu_items' => [
            ['_id'=>new ObjectId(),'name'=>'Classic Beef Burger','price'=>320.0,'type'=>'non_veg','spice_level'=>'low','is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Spicy Chicken Burger','price'=>280.0,'type'=>'non_veg','spice_level'=>'high','is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Veggie Supreme Burger','price'=>220.0,'type'=>'veg','is_jain'=>false,'is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Loaded Fries','price'=>150.0,'type'=>'veg','is_jain'=>false,'is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Chocolate Milkshake','price'=>160.0,'type'=>'beverage','serving_size_ml'=>500,'is_available'=>true,'created_at'=>ts()],
            ['_id'=>new ObjectId(),'name'=>'Classic Cola','price'=>60.0,'type'=>'beverage','serving_size_ml'=>350,'is_available'=>true,'created_at'=>ts()],
        ],
    ],
];

$restCol = $db->selectCollection('restaurants');
$restIds = [];
foreach ($restaurants as $r) {
    $res = $restCol->insertOne($r);
    $restIds[] = (string)$res->getInsertedId();
    echo "✓ Restaurant: {$r['name']}\n";
}

// ─── 2. Users ─────────────────────────────────────────────────────────────────
$users = [
    [
        'name' => 'Arjun Mehta',
        'email' => 'arjun@example.com',
        'password' => password_hash('user123', PASSWORD_BCRYPT),
        'phone' => '9000000001',
        'addresses' => [
            ['_id'=>new ObjectId(),'street'=>'42 Park Avenue','city'=>'Bangalore','pincode'=>'560001','landmark'=>'Near Central Park','created_at'=>ts()],
            ['_id'=>new ObjectId(),'street'=>'Office: Tech Hub, Koramangala','city'=>'Bangalore','pincode'=>'560034','landmark'=>'Near Cafe Coffee Day','created_at'=>ts()],
        ],
        'favorites' => [$restIds[0], $restIds[2]],
        'created_at' => ts('-10 days'), 'updated_at' => ts(),
    ],
    [
        'name' => 'Priya Sharma',
        'email' => 'priya@example.com',
        'password' => password_hash('user123', PASSWORD_BCRYPT),
        'phone' => '9000000002',
        'addresses' => [
            ['_id'=>new ObjectId(),'street'=>'8 Marine Lines','city'=>'Mumbai','pincode'=>'400020','landmark'=>'Opposite Grand Hotel','created_at'=>ts()],
        ],
        'favorites' => [$restIds[1]],
        'created_at' => ts('-8 days'), 'updated_at' => ts(),
    ],
    [
        'name' => 'Rahul Kumar',
        'email' => 'rahul@example.com',
        'password' => password_hash('user123', PASSWORD_BCRYPT),
        'phone' => '9000000003',
        'addresses' => [
            ['_id'=>new ObjectId(),'street'=>'15 T Nagar','city'=>'Chennai','pincode'=>'600017','landmark'=>'Near Pondy Bazaar','created_at'=>ts()],
            ['_id'=>new ObjectId(),'street'=>'Flat 3B, Green Valley Apartments, Velachery','city'=>'Chennai','pincode'=>'600042','landmark'=>'','created_at'=>ts()],
        ],
        'favorites' => [$restIds[3]],
        'created_at' => ts('-5 days'), 'updated_at' => ts(),
    ],
];

$userCol = $db->selectCollection('users');
$userIds = [];
foreach ($users as $u) {
    $res = $userCol->insertOne($u);
    $userIds[] = (string)$res->getInsertedId();
    echo "✓ User: {$u['name']}\n";
}

// ─── 3. Orders (20 orders) ────────────────────────────────────────────────────
$statuses = ['delivered','delivered','delivered','delivered','out_for_delivery','preparing','placed','cancelled'];
$orderCol = $db->selectCollection('orders');
$orderIds = [];

$sampleOrders = [];
for ($i = 0; $i < 20; $i++) {
    $rIdx   = $i % count($restIds);
    $uIdx   = $i % count($userIds);
    $rest   = $restaurants[$rIdx];
    $menu   = $rest['menu_items'];
    $item1  = $menu[array_rand($menu)];
    $item2  = $menu[array_rand($menu)];
    $qty1   = rand(1,3); $qty2 = rand(1,2);
    $total  = ($item1['price'] * $qty1) + ($item2['price'] * $qty2) + ($rest['delivery_fee'] ?? 30);
    $status = $statuses[$i % count($statuses)];

    $placedAt   = new UTCDateTime(new DateTime('-' . (30 - $i) . ' hours'));
    $deliveredAt= $status === 'delivered' ? new UTCDateTime((new DateTime('-' . (30 - $i) . ' hours'))->modify('+35 minutes')) : null;

    $order = [
        'user_id'          => $userIds[$uIdx],
        'restaurant_id'    => $restIds[$rIdx],
        'items'            => [
            ['item_id'=>(string)$item1['_id'],'name'=>$item1['name'],'price'=>$item1['price'],'quantity'=>$qty1,'type'=>$item1['type']],
            ['item_id'=>(string)$item2['_id'],'name'=>$item2['name'],'price'=>$item2['price'],'quantity'=>$qty2,'type'=>$item2['type']],
        ],
        'total_price'      => $total,
        'delivery_address' => ['street'=>'Sample Street','city'=>'City','pincode'=>'100001'],
        'status'           => $status,
        'notes'            => '',
        'eta_minutes'      => 30,
        'placed_at'        => $placedAt,
        'accepted_at'      => in_array($status,['accepted','preparing','out_for_delivery','delivered']) ? new UTCDateTime((new DateTime())->modify("-{$i} hours +5 min")) : null,
        'preparing_at'     => in_array($status,['preparing','out_for_delivery','delivered']) ? new UTCDateTime((new DateTime())->modify("-{$i} hours +10 min")) : null,
        'out_for_delivery_at' => in_array($status,['out_for_delivery','delivered']) ? new UTCDateTime((new DateTime())->modify("-{$i} hours +25 min")) : null,
        'delivered_at'     => $deliveredAt,
        'cancelled_at'     => $status==='cancelled' ? new UTCDateTime() : null,
    ];

    $res = $orderCol->insertOne($order);
    $orderId = (string)$res->getInsertedId();
    $orderIds[] = $orderId;

    // Store active orders in Redis
    if (!in_array($status, ['delivered','cancelled']) && RedisClient::isAvailable()) {
        $redis->hmset("order:{$orderId}", [
            'status'        => $status,
            'user_id'       => $userIds[$uIdx],
            'restaurant_id' => $restIds[$rIdx],
            'eta'           => '20 mins',
            'placed_at'     => date('c'),
            'updated_at'    => date('c'),
        ]);
        $redis->expire("order:{$orderId}", 86400);
        if ($status === 'placed') $redis->rpush(DELIVERY_QUEUE_KEY, $orderId);
    }
}
echo "✓ 20 Orders inserted\n";

// ─── 4. Reviews ───────────────────────────────────────────────────────────────
$comments = [
    'Amazing food, super fast delivery!',
    'Loved the taste, will order again.',
    'Good food but a bit spicy for me.',
    'Perfect portion size and great packaging.',
    'The best restaurant in the area!',
];
$reviewCol = $db->selectCollection('reviews');
for ($i = 0; $i < 10; $i++) {
    $reviewCol->insertOne([
        'user_id'       => $userIds[$i % count($userIds)],
        'user_name'     => $users[$i % count($users)]['name'],
        'restaurant_id' => $restIds[$i % count($restIds)],
        'order_id'      => $orderIds[$i],
        'rating'        => (float)(3 + ($i % 3)),
        'comment'       => $comments[$i % count($comments)],
        'created_at'    => ts('-' . (5-$i%5) . ' days'),
    ]);
}
echo "✓ 10 Reviews inserted\n";

// ─── 5. Redis Keys ────────────────────────────────────────────────────────────
if (RedisClient::isAvailable()) {
    foreach ($restIds as $rId) {
        $redis->set("restaurant:{$rId}:online", '1', RESTAURANT_ONLINE_TTL);
    }
    echo "✓ Restaurant online keys set in Redis\n";
    echo "✓ Delivery queue length: " . $redis->llen(DELIVERY_QUEUE_KEY) . "\n";
} else {
    echo "⚠  Redis unavailable — skipping Redis keys\n";
}

echo "\n🎉 Seeding complete!\n";
echo "---\n";
echo "Test credentials:\n";
echo "  User:       arjun@example.com / user123\n";
echo "  Restaurant: spice@example.com / password123\n";
echo "  Admin:      admin@foodrush.com / admin123\n";

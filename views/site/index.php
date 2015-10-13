<?php
use scotthuangzl\googlechart\GoogleChart;
use yii\db\ActiveQuery;

/* @var $this yii\web\View */

$this->title = 'AliExpress Order Management System';
$connection = Yii::$app->getDb();

//$packages = \app\models\Package::find()->addGroupBy('')->asArray()->all();

$packages_command = $connection->createCommand('SELECT count(*) as number_of_orders, status FROM package GROUP BY status ORDER BY number_of_orders DESC;');
$packages = $packages_command->queryAll();

if (!empty($packages)) {
    $package_arr = array();
    $package_arr[0] = array(0 => "Status", 1 => "# of orders");
    $i = 1;
    foreach ($packages as $package) {
        $package[0] = $package['status'];
        $package[1] = $package['number_of_orders'];
        $package_arr[$i] = array($package);
        $i++;
    }
    print_r($packages);
    print_r(array(
        array('Task', 'Hours per Day'),
        array('Work', 11),
        array('Eat', 2),
        array('Commute', 2),
        array('Watch TV', 2),
        array('Sleep', 7)
    ));
}
?>
<div class="site-index">

    <div class="jumbotron">
        <h2>AliExpress Management System!</h2>

        <p class="lead">Please find below some stats</p>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Packages</h2>

                <p><?php
                    echo GoogleChart::widget(array('visualization' => 'LineChart',
                        'data' => array(
                            array('Task', 'Hours per Day'),
                            array('Work', 11),
                            array('Eat', 2),
                            array('Commute', 2),
                            array('Watch TV', 2),
                            array('Sleep', 7)
                        ),
                        'options' => array('title' => 'My Daily Activity')));
                    ?></p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Stores</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Couriers</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>

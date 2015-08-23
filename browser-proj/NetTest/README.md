# NetTest
PHP class for testing internet client speed

## Example
Run example and setting the sensitivity param for speed internet connection
```
example.php?sensitivity=50
```
![NetTes](https://raw.githubusercontent.com/ilopX/web-demos-proj/master/projects/NetTest/example.png)

## Download
[NetTest.php](https://cdn.rawgit.com/ilopX/web-demos-proj/master/libs/NetTest.php)

## Create
The frequency of testing Internet speed
```php
$netTest = new NetTest(); // default NetTest::CHECK_ALWAYS
$netTest = new NetTest(NetTest::CHECK_ALWAYS); 
$netTest = new NetTest(NetTest::CHECK_ONE_TIME);
$netTest = new NetTest(NetTest::CHECK_FIVE_TIME);
$netTest = new NetTest(NetTest::CHECK_TEN_TIME);
```

## Time
Time of load minimum send data
```php
$netTest->getTime();
```

## Speed 1-100
- 1 - low speed
- 100 - high speed
```php
$netTest->getSpeed();
```

## Speed name
* 100 - "WiFi"
* 98 - "DSL"
* 94 - "4G"
* 90 - "Good 3G"
* 80 - "3G"
* 70 - "Good 2G"
* 30 - "2G"
* < 30 - "GPRS";
```php
$netTest->getSpeedName();
```

## Sensitivity
Default 50
```php
$netTest->setSensitivity(50);
```
## Video
[![Demo](http://img.youtube.com/vi/2pdT7EqgtOs/0.jpg)](http://www.youtube.com/watch?v=2pdT7EqgtOs)

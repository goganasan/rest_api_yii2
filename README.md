<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Test task - simple rest api converter</h1>
    <br>
</p>

# 1.First task - SQL code
![Image alt](https://github.com/goganasan/rest_api_yii2/raw/master/images/image.png)

<pre><i>SELECT u.id, u.firstName || ',' || u.lastName, bk.author, group_concat(bk.name)<br>
FROM Users u <br>
 &nbsp; INNER JOIN User_Books b <br>
 &nbsp;&nbsp;   ON u.id = b.user_id <br>
 &nbsp; INNER JOIN Books bk <br>
 &nbsp;&nbsp;   ON b.book_id = bk.id <br>
WHERE u.age BETWEEN 7 AND 17 <br>
 &nbsp;AND u.id IN <br>
 &nbsp;&nbsp;   (SELECT user_id FROM User_Books GROUP BY user_id HAVING COUNT(*) = 2) <br>
GROUP BY u.id HAVING COUNT(DISTINCT bk.author) = 1 <br></i></pre>


# 2.Second task - Restful api currency converter

Run application:

clone project inside your virtual host root directory: git clone https://github.com/goganasan/rest_api_yii2.git .
go to project directory and run command: composer install
open /config/db.php and setup your database configurations
run project migrations: ./yii migrate/up

==================================================================================

User login (get access token):

POST api/v1/users/login HTTP/1.1
Host: 127.0.0.1:8080

username=ivanov&password=ivanov

For test you can use page
http://localhost/currency-exchange/api/v1/users/login?username=ivanov&password=ivanov
result example:
<pre><i>{"access_token":"CyKieUrNrQrQymnal5LyLF4TUOIpIyUl"}</pre></i>

==================================================================================

All next requests must have user access token. Result without or bad token:

<pre><i>{"status":"error","code":401,"message":"Your request was made with invalid credentials."}</pre></i>

==================================================================================

<p><b>First method:</p></b>

GET api/v1/rates HTTP/1.1
Host: 127.0.0.1:8080
Authorization: Bearer CyKieUrNrQrQymnal5LyLF4TUOIpIyUl   <<< user access token

If not parameters, or they not correct, we have result all currency fields

result example:
<pre><i>{"status":"success","code":200,"data":{"GBP":{"15m":34599.83,"last":34599.83,"buy":36012.07,"sell":34599.83,"symbol":"£"},"EUR":{"15m":39561.92,"last":39561.92,"buy":41176.7,"sell":39561.92,"symbol":"€"},"CHF":{"15m":42753.37,"last":42753.37,"buy":44498.41,"sell":42753.37,"symbol":"CHF"},"USD":{"15m":47938.06,"last":47938.06,"buy":49894.72,"sell":47938.06,"symbol":"$"},"CAD":{"15m":60802.48,"last":60802.48,"buy":63284.22,"sell":60802.48,"symbol":"$"},"AUD":{"15m":61777.79,"last":61777.79,"buy":64299.33,"sell":61777.79,"symbol":"$"},"SGD":{"15m":63541.67,"last":63541.67,"buy":66135.21,"sell":63541.67,"symbol":"$"},"NZD":{"15m":66443.6,"last":66443.6,"buy":69155.58,"sell":66443.6,"symbol":"$"},"PLN":{"15m":177872.52,"last":177872.52,"buy":185132.62,"sell":177872.52,"symbol":"zł"},"BRL":{"15m":257444.2,"last":257444.2,"buy":267952.12,"sell":257444.2,"symbol":"R$"},"DKK":{"15m":294105.03,"last":294105.03,"buy":306109.31,"sell":294105.03,"symbol":"kr"},"CNY":{"15m":309588.83,"last":309588.83,"buy":322225.11,"sell":309588.83,"symbol":"¥"},"TRY":{"15m":337193.29,"last":337193.29,"buy":350956.29,"sell":337193.29,"symbol":"₺"},"HKD":{"15m":371657.6,"last":371657.6,"buy":386827.3,"sell":371657.6,"symbol":"$"},"SEK":{"15m":398065.48,"last":398065.48,"buy":414313.06,"sell":398065.48,"symbol":"kr"},"TWD":{"15m":1343713.59,"last":1343713.59,"buy":1398559.05,"sell":1343713.59,"symbol":"NT$"},"THB":{"15m":1431418.02,"last":1431418.02,"buy":1489843.24,"sell":1431418.02,"symbol":"฿"},"INR":{"15m":3479874.6,"last":3479874.6,"buy":3621910.3,"sell":3479874.6,"symbol":"₹"},"RUB":{"15m":3533404.64,"last":3533404.64,"buy":3677625.24,"sell":3533404.64,"symbol":"RUB"},"JPY":{"15m":5034136.84,"last":5034136.84,"buy":5239611.82,"sell":5034136.84,"symbol":"¥"},"ISK":{"15m":6155727.15,"last":6155727.15,"buy":6406981.31,"sell":6155727.15,"symbol":"kr"},"CLP":{"15m":34601620.88,"last":34601620.88,"buy":36013931.94,"sell":34601620.88,"symbol":"$"},"KRW":{"15m":52941362.77,"last":52941362.77,"buy":55102234.71,"sell":52941362.77,"symbol":"₩"}}}</pre></i>

If we set parameter 'currency' like 'USD'

result example:
<pre><i>{"status":"success","code":200,"data":{"15m":47944.97,"last":47944.97,"buy":49901.91,"sell":47944.97,"symbol":"$"}}</pre></i>

==================================================================================

<p><b>Second method:</b></p>

POST api/v1/convert HTTP/1.1
Host: 127.0.0.1:8080
Authorization: Bearer CyKieUrNrQrQymnal5LyLF4TUOIpIyUl

For convert BTC to other currency or backward we have to set 3 parameters: currensyFrom, currencyTo and value

result example:
<pre><i>{"status":"success","code":200,"data":{"currency_from":"BTC","currency_to":"USD","value":0.01,"converted_value":0.01,"rate":481.57}}</pre></i>

If set not correct parameters, or value currency less then 0.01, we get 413 error 

result example:
{"status":"error","code":413,"message":"Please check yor request, params with errors"}

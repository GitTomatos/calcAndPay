Разворачивание проекта
==========

Чтобы развернуть проект, нужно выполнить `make init`

Запросы для ручного тестирования
==========

calc-price
----------

1. Успешный со скидкой

```
curl --location 'localhost:88/calculate-price' \
--header 'Content-Type: application/json' \
--data '{
"product": 1,
"taxNumber": "FRAA123456789",
"couponCode": "FAD5"
}'
```

2. Успешный без скидки

```
curl --location 'localhost:88/calculate-price' \
--header 'Content-Type: application/json' \
--data '{
"product": 1,
"taxNumber": "FRAA123456789"
}'
```

3. Ошибка валидации

```
curl --location 'localhost:88/calculate-price' \
--header 'Content-Type: application/json' \
--data '{
"product": -1,
"taxNumber": "FRA1123456789"
}'
```

purchase
----------

1. Успешный без скидки

```
curl --location 'localhost:88/purchase' \
--header 'Content-Type: application/json' \
--data '{
"product": 1,
"taxNumber": "IT12345678900",
"paymentProcessor": "paypal"
}'
```

2. Успешный со скидкой

```
curl --location 'localhost:88/purchase' \
--header 'Content-Type: application/json' \
--data '{
"product": 1,
"taxNumber": "IT12345678900",
"couponCode": "FAD5",
"paymentProcessor": "paypal"
}'
```

3. Ошибка stripe

```
curl --location 'localhost:88/purchase' \
--header 'Content-Type: application/json' \
--data '{
"product": 1,
"taxNumber": "IT12345678900",
"couponCode": "FAD100",
"paymentProcessor": "stripe"
}'
```

4. Ошибка paypal

```
curl --location 'localhost:88/purchase' \
--header 'Content-Type: application/json' \
--data '{
"product": 4,
"taxNumber": "IT12345678900",
"paymentProcessor": "paypal"
}'
```

5. Ошибка валидации

```
curl --location 'localhost:88/purchase' \
--header 'Content-Type: application/json' \
--data '{
"product": -1,
"taxNumber": "IT123456789в00",
"couponCode": "F1",
"paymentProcessor": "test"
}'
```
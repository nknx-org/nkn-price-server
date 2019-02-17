---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://price.nknx.org/docs/collection.json)

<!-- END_INFO -->

#general
<!-- START_31ba3404dd41d17f344294738eba57ec -->
## Get current prices of Quote

Returns chosen quotes and the current prices of the chosen currency

> Example request:

```bash
curl -X GET -G "https://price.nknx.org/price" 
```

```javascript
const url = new URL("https://price.nknx.org/price");

    let params = {
            "quote": "NKN",
            "currency": "USD,ETH",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
[
    {
        "id": 4,
        "name": "NKN",
        "symbol": "NKN",
        "slug": "nkn",
        "circulating_supply": 350000000,
        "total_supply": 700000000,
        "max_supply": 1000000000,
        "date_added": "2018-05-28 00:00:00",
        "num_market_pairs": 10,
        "cmc_rank": 225,
        "created_at": "2019-02-17 18:12:55",
        "updated_at": "2019-02-17 18:12:55",
        "prices": [
            {
                "id": 7,
                "currency": "USD",
                "price": 0.02965803,
                "volume_24h": 1099077.96089714,
                "percent_change_1h": -1.41729,
                "percent_change_24h": 7.46267,
                "percent_change_7d": 8.81945,
                "market_cap": 10380311.98421,
                "quote_id": 4,
                "created_at": "2019-02-17 18:12:55",
                "updated_at": "2019-02-17 18:12:55"
            },
            {
                "id": 8,
                "currency": "ETH",
                "price": 0.00023162,
                "volume_24h": 8583.39654573,
                "percent_change_1h": -2.1209,
                "percent_change_24h": 3.5435,
                "percent_change_7d": 1.1349,
                "market_cap": 81066.43677588,
                "quote_id": 4,
                "created_at": "2019-02-17 18:12:55",
                "updated_at": "2019-02-17 18:12:55"
            }
        ]
    }
]
```

### HTTP Request
`GET price`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    quote |  required  | The symbols you want to get returned
    currency |  required  | The currencies you want to get

<!-- END_31ba3404dd41d17f344294738eba57ec -->

<!-- START_8a9b19b7b9bcd62ad9f446ec32720fd8 -->
## Get History of Quotes

Returns chosen quotes and the history prices of the chosen currency based on the aggregation level

> Example request:

```bash
curl -X GET -G "https://price.nknx.org/history" 
```

```javascript
const url = new URL("https://price.nknx.org/history");

    let params = {
            "quote": "NKN",
            "currency": "USD,ETH",
            "aggregate": "days",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
[
    {
        "symbol": "NKN",
        "USD": [
            {
                "price": 0.029990305000000002,
                "date": "2019-02-17"
            }
        ],
        "ETH": [
            {
                "price": 0.0002358175,
                "date": "2019-02-17"
            }
        ]
    }
]
```

### HTTP Request
`GET history`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    quote |  required  | The symbols you want to get returned
    currency |  required  | The currencies you want to get
    aggregate |  required  | The currencies you want to get

<!-- END_8a9b19b7b9bcd62ad9f446ec32720fd8 -->



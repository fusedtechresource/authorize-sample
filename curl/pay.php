<?php
  $login_id = '48Sgy6UKYZ';
  $login_key = '4jDE94h568EAc6jd';
  $api = 'https://apitest.authorize.net/xml/v1/request.api';
  $transaction = array(
    'createTransactionRequest' => [
      'merchantAuthentication' => [
        'name' => $login_id,
        'transactionKey' => $login_key,
      ],
      'refId' => 'ref' . time(),
      'transactionRequest' => [
        'transactionType' => 'authCaptureTransaction',
        'amount' => '5',
        'payment' => [
          'creditCard' => [
            'cardNumber' => '5424000000000015',
            'expirationDate' => '2020-12',
            'cardCode' => '999'
          ]
          ],
          'lineItems' => [
            'lineItem' => [
              'itemId' =>  1,
              'name' => 'vase',
              'description' => 'Cannes logo',
              'quantity' => '18',
              'unitPrice' =>  '45.00'
            ]
          ],
          'tax' => [
            'amount' => '4.26',
            'name' => 'level2 tax name',
            'description' => 'level2 tax', 
          ],
          'duty' =>[
            'amount' => '8.55',
            'name' => 'duty name',
            'description' => 'duty description'
          ],
          'shipping' => [
            'amount' => '4.26',
            'name' => 'level2 tax name',
            'description' => 'level2 tax'
          ],
          'poNumber' => '456654',
          'customer' => [
            'id' => '99999456654'
          ],
          'billTo' => [
            'firstName' => 'Ellen',
            'lastName' => 'Johnson',
            'company' => 'Souveniropolis',
            'address' => '14 Main Street',
            'city' => 'Pecan Springs',
            'state' => 'TX',
            'zip' => '44628',
            'country' => 'USA'
          ],
          'shipTo' => [
            'firstName' => 'China',
            'lastName' => 'Bayles',
            'company' => 'Thyme for Tea',
            'address' => '12 Main Street',
            'city' => 'Pecan Springs',
            'state' => 'TX',
            'zip' => '44628',
            'country'=> 'USA',
          ],
          'customerIP' => '192.168.1.1',
          'userFields' => [
            'userField' => array(
              [
                'name' => 'MerchantDefinedFieldName1',
                'value' => 'MerchantDefinedFieldValue1'
              ],
              [
                'name' => 'favorite_color',
                'value' => 'blue'
              ]
            )
          ]
      ]
    ]
  );
  $transaction_encode = json_encode($transaction);

  $response = send($api,$transaction_encode);
  $result =  json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response));
  echo '<pre>';
  print_r($result);
  echo '</pre>';

  function send($url, $input,$content_type = "Content-Type: application/json") {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_HTTPHEADER, Array('Content-type: application/json'));
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $input);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    $err = curl_error($ch);
    if($err){
      return $err;
    }
    curl_close($ch);
    return $result;
  }
?>
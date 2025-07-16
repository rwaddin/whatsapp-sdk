# whatsapp-sdk

Whatsapp API SDK hanya untuk penggunaan keperluan perusahaan

## Core concept

Penting untuk diketahui penggunaan sdk ini dipakai di end aplikasi, tidak menghandle langsung hook pada whatsapp.

```md
1. Facebook akan mengirim WebHook ke gateway contoh gateway.domain.id
2. Gateway melakukan handshake dengan facebook terkait webhook apakah sesuai key atau tidak
3. Gateway meneruskan hook facebook ke end aplikasi contoh end.domain.id
4. end aplikasi inilah yang akan menggunakan sdk ini
```

## Information

Ada beberapa type webhook yang dikirim oleh facebook

1. Message

    - text
    - image
    - sticker
    - documents
    - unknown (ex pesan tidak support)
    - button

2. Status

    - sent
    - delivered
    - read
    - failed

## Features

- [x] Send text message
- [x] Generate webhook message (bukan memvalidasi webhook facebook secara langsung)
- [ ] Send image message
- [ ] Send document message

## Example error

```md
Array
(
    [error] => Array
        (
            [message] => Invalid OAuth access token - Cannot parse access token
            [type] => OAuthException
            [code] => 190
            [fbtrace_id] => AtYQl3mJPwLPhH-m_buoHAI
        )

)
```


## Hook

hook contoh dibawah merupakah return dari method berikut:

```php
$hook = ['array data from facebook'];
$webhook = new Rumahweb\Webhook($hook);
print_r($hook);
```

Keterangan :

- `phone_display` : Nomor hp whatsapp
- `phone_id` : Phone number id device whatsapp
- `hook_type` : saat ini hanya ada 2 (`message` & `status`)
- `wamid` : WhatsApp message ID

### Message type

Text message

```json
{
  "phone_display": "1234567890",
  "phone_id": "987654321",
  "hook_type": "message",
  "from_name": "addin",
  "from_phone": "6285747277xxx",
  "wamid": "wamid.HBgNNjI4NTxxxxxx",
  "timestamp": "1746604743",
  "type": "text",
  "text": "Halo ini pesan dari addin"
}
```

### Status Type

- `recipient_phone` : penerima message

Status Delivered

```json
{
  "phone_display": "1234567890",
  "phone_id": "987654321",
  "hook_type": "status",
  "wamid": "wamid.HBgNNxxxx",
  "status": "delivered",
  "timestamp": "1746595471",
  "recipient_phone": "6285747277xxx"
}
```

Status sent

```json
{
  "phone_display": "1234567890",
  "phone_id": "987654321",
  "hook_type": "status",
  "wamid": "wamid.HBgNNjIxx",
  "status": "sent",
  "timestamp": "1752630521",
  "recipient_phone": "6285747277xxx"
}
```

Status Failed

```json
{
  "phone_display": "1234567890",
  "phone_id": "987654321",
  "hook_type": "status",
  "wamid": "wamid.HBgNxx",
  "status": "failed",
  "timestamp": "1752629020",
  "recipient_phone": "6285747277xxx"
}
```

Status Read

```json
{
  "phone_display": "1234567890",
  "phone_id": "987654321",
  "hook_type": "status",
  "wamid": "wamid.HBgNNjxx",
  "status": "read",
  "timestamp": "1752630698",
  "recipient_phone": "6285747277xxx"
}
```

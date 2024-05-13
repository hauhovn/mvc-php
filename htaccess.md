; Kích hoạt module mod_rewrite cho Apache. Module này cho phép URL rewriting
RewriteEngine On
; Đây là một điều kiện RewriteCond, nó kiểm tra xem yêu cầu có phải là
;  một thư mục không (không phải một tên thư mục đã tồn tại trong hệ
;   thống tệp không). Nếu không phải, nó tiếp tục xử lý các quy tắc chuyển tiếp
RewriteCond %{REQUEST_FILENAME} !-d
; nó kiểm tra xem yêu cầu có phải là một tệp không (không phải một tên tệp
;  đã tồn tại trong hệ thống tệp không). Nếu không phải, nó tiếp tục xử lý
;   các quy tắc chuyển tiếp
RewriteCond %{REQUEST_FILENAME} !-f

; Thêm [QSA] vào cuối quy tắc RewriteRule là viết tắt
;  của "Query String Append", điều này cho phép các 
;  tham số query string được chuyển tiếp từ URL gốc đến trang index.php
RewriteRule ^(.*)$ index.php?url=$1 [QSA]
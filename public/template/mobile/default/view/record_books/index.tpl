
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>我的出入账</title>
        <meta charset="UTF-8">
        {include file="public/js_css" /}
        <link rel="stylesheet" type="text/css" href="__MOBILE__/css/record_books/index.css" />
    </head>
    <body>

        <div class="allhtml">
            {include file="public/top_text" /}
            <div class="record_books-all allas">
                <div class="record_books-top">
                    <div class="record_bookstop-auto">
                        <div class="record_books-active" data-bookstype="into">入账</div>
                        <div data-bookstype="out">出账</div>
                    </div>
                </div>
                <div class="record_books-list" id="record_bookslist_alldiv">
                    <ul class="record_bookslist-ul" id="record_books_listul">
                        
                    </ul>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="__MOBILE__/js/record_books/index.js"></script>

    </body>
</html>

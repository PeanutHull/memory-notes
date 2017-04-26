1. XMLHttpRequest
   - 方法
        ```PHP
        var request = new XMLHttpRequest;
        request.open("GET", "get.php", true);
        request.send();
        request.onreadystatechange = function() {}
        ```
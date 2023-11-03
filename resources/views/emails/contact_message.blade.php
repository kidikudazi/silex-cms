<html>
<head>
    <style>
        body {
            font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
            font-weight: 500;
            font-size: 16px;
            line-height: 1.5;
            color: #26103d;
        }

        .container {
            margin: 0 auto;
            max-width: 560px;
            margin-top: 120px;
        }

        h1 {
            font-size: 20px;
            color: 
        }

        img {
            height: 20px;
            padding: 0 2px;
        }

        a,
        a:hover,
        a:active,
        a:visited {
            text-decoration: none;
            font-weight: 800;
            color: #5200F5;
        }

        a.button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #5200F5;
            color: white;
            font-weight: 500;
            border-radius: 4px;
            margin: 0 10px;
        }
    </style>
</head>
<body style="font-family: -apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,Oxygen-Sans,Ubuntu,Cantarell,&quot;Helvetica Neue&quot;,sans-serif;font-weight: 500;font-size: 16px;line-height: 1.5;color: #26103d;">
    <div class="container" style="margin-top: 0 auto; max-width: 560px;">
        <p>A new Message from {{ $data['fullname'] }}</p>
        <p>Email address: <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></p>
        <hr>
        <p>{{ $data['content'] }}</p>        
    </div>
</body>
</html>
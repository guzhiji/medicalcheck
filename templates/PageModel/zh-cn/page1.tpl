<!DOCTYPE html> 
<html> 
    <head> 
        <meta charset="utf-8">
        <title>体检记录系统</title> 
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <link rel="stylesheet" href="jquery.mobile-1.2.0.min.css" />
        <script src="scripts/jquery.min.js"></script>
        <script src="scripts/jquery.mobile-1.2.0.min.js"></script>
    </head> 
    <body>

        <div data-role="page">

            <div data-role="header" data-position="fixed">
                {$LeftButton}
                <h1>{$Title}</h1>
                {$RightButton}
                {$TopNav}
            </div><!-- /header -->

            <div data-role="content">
                {$Content}
            </div><!-- /content -->

            <div data-role="footer" data-position="fixed">
                <div data-role="controlgroup" data-type="horizontal"> 
                    {$PrevPageButton}
                    {$NextPageButton}
                </div>
            </div><!-- /footer -->

        </div><!-- /page -->

    </body>
</html>

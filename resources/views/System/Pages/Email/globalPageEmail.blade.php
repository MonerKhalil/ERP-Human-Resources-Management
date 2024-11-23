<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Email</title>
        {{-- Main CSS System --}}
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap');

            body {
                font-family: Roboto , sans-serif;
                font-size: 1.6rem ;
                font-weight: 400;
                line-height: 1.5;
            }

            .EmailPage #bodyTable {
                table-layout: fixed;
                background-color: #f9f9f9;
            }
            .EmailPage .wrapperWebview {
                max-width: 600px;
            }
            .EmailPage .wrapperWebview .webview {
                padding-top: 20px;
                padding-bottom: 20px;
                padding-right: 0;
            }
            .EmailPage .wrapperWebview .webview .Logo {
                width: 60px;
                height: 60px;
                border-radius: 50%;
            }
            .EmailPage .wrapperBody {
                max-width: 600px;
            }
            .EmailPage .wrapperBody .tableCard {
                background-color: #fff;
                border-color: #e5e5e5;
                border-style: solid;
                border-width: 0 1px 1px 1px;
            }
            .EmailPage .wrapperBody .tableCard .topBorder {
                background-color: #00d2f4;
                font-size: 1px;
                line-height: 3px;
            }
            .EmailPage .wrapperBody .tableCard .imgHero {
                padding-bottom: 20px;
            }
            .EmailPage .wrapperBody .tableCard .imgHero a {
                text-decoration: none;
            }
            .EmailPage .wrapperBody .tableCard .imgHero a img {
                width: 100%;
                max-width: 200px;
                height: auto;
                display: block;
                color: #f9f9f9;
            }
            .EmailPage .wrapperBody .tableCard .containtTable {
                padding-left: 20px;
                padding-right: 20px;
            }
            .EmailPage .wrapperBody .tableCard .containtTable .description {
                padding-left: 30px;
                padding-right: 30px;
            }
            .EmailPage .wrapperBody .tableCard .containtTable .description .Group:not(:last-child) {
                margin-bottom: 10px;
            }
            .EmailPage .wrapperBody .tableCard .containtTable .description .Group .text {
                color: #666;
                font-family: "Open Sans", Helvetica, Arial, sans-serif;
                font-size: 14px;
                font-weight: 400;
                font-style: normal;
                letter-spacing: normal;
                line-height: 22px;
                text-transform: none;
                text-align: initial;
                padding: 0;
                margin: 0;
                padding-bottom: 20px;
            }
            .EmailPage .wrapperBody .tableCard .containtTable .description .Group .list {
                color: #666;
                font-family: "Open Sans", Helvetica, Arial, sans-serif;
                font-size: 14px;
                font-weight: 400;
                font-style: normal;
                letter-spacing: normal;
                line-height: 22px;
                text-transform: none;
                margin-left: 0;
                list-style: initial;
                padding-bottom: 20px;
                padding-left: 15px;
            }
            .EmailPage .wrapperBody .tableCard .containtTable .description .Group .list li {
                margin-bottom: 10px;
            }
            .EmailPage .wrapperBody .tableCard .containtTable .description .Group .title {
                font-size: 20px;
                font-weight: 600;
                text-transform: capitalize;
                margin-bottom: 10px;
            }
            .EmailPage .wrapperBody .tableCard .tableButton .contentCtaButton {
                padding-top: 20px;
                padding-bottom: 20px;
            }
            .EmailPage .wrapperBody .tableCard .tableButton .ctaButton {
                background-color: #00d2f4;
                padding: 12px 35px;
                border-radius: 50px;
            }
            .EmailPage .wrapperBody .tableCard .tableButton .ctaButton .text {
                color: #fff;
                font-family: Poppins, Helvetica, Arial, sans-serif;
                font-size: 13px;
                font-weight: 600;
                font-style: normal;
                letter-spacing: 1px;
                line-height: 20px;
                text-transform: uppercase;
                text-decoration: none;
                display: block;
            }
            .EmailPage .wrapperBody .tableCard .mainTitle .text {
                position: relative;
                color: #000;
                font-family: Poppins, Helvetica, Arial, sans-serif;
                font-size: 28px;
                font-weight: 500;
                font-style: normal;
                letter-spacing: normal;
                line-height: 36px;
                text-transform: none;
                text-align: center;
                padding-bottom: 20px;
                padding-left: 20px;
                padding-right: 20px;
                margin-bottom: 30px;
            }
            .EmailPage .wrapperBody .tableCard .mainTitle .text::after {
                content: "";
                position: absolute;
                bottom: 0;
                left: 0;
                background-color: #00d2f4;
                height: 2px;
                width: 100%;
            }
        </style>
    </head>
    <body class="EmailPage">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" id="bodyTable">
            <tbody>
            <tr>
                <td align="center" valign="top" id="bodyCell">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperWebview">
                        <tbody>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td align="center" valign="middle" class="webview">
                                                    <img src="{{ asset("System/Assets/Images/Logo.png") }}"
                                                         alt="Logo" class="Logo">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperBody">
                        <tbody>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableCard">
                                        <tbody>
                                            <tr>
                                                <td class="topBorder" height="3">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td align="center" valign="top" class="imgHero">
                                                    <a>
                                                        <img alt="" border="0"
                                                             src="{{ asset("System/Assets/Images/emailImage.png") }}"
                                                             width="600">
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" valign="top" class="mainTitle">
                                                    <h2 class="text">Email Verfication</h2>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" valign="top" class="containtTable ui-sortable">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" class="description">
                                                                    <div class="Group">
                                                                        <h3 class="title">title : </h3>
                                                                        <p class="text" >Thanks for subscribe for the Vespro newsletter. Please click confirm button for subscription to start receiving our emails.</p>
                                                                        <ul class="list">
                                                                            <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                                                                            <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                                                                            <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="Group">
                                                                        <h3 class="title">title : </h3>
                                                                        <p class="text" >Thanks for subscribe for the Vespro newsletter. Please click confirm button for subscription to start receiving our emails.</p>
                                                                        <ul class="list">
                                                                            <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                                                                            <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                                                                            <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableButton">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" valign="top" class="contentCtaButton">
                                                                    <table border="0" cellpadding="0" cellspacing="0" align="center">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="center" class="ctaButton">
                                                                                    <a href="#" target="_blank" class="text">Confirm Email</a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </body>
</html>

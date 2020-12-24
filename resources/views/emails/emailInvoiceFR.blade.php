<style>

    @import url(https://fonts.googleapis.com/css?family=Roboto:100,300,400,900,700,500,300,100);
    #invoiceholder *{
        margin: 0;
        box-sizing: border-box;

    }
    ::selection {background: #f31544; color: #FFF;}
    ::moz-selection {background: #f31544; color: #FFF;}
    h1{
        font-size: 1.5em;
        color: #222;
    }
    h2{font-size: .9em;}
    h3{
        font-size: 1.2em;
        font-weight: 300;
        line-height: 2em;
    }
    #invoiceholder p{
        font-size: .7em;
        color: #666;
        line-height: 1.2em;
    }

    #invoiceholder{
        width:100%;
        height: 100%;
        padding-top: 50px;
    }
    #invoice{
        position: relative;
        top: -50px;
        margin: 0 auto;
        width: 700px;
        background: #FFF;
    }

    [id*='invoice-']{ /* Targets all id with 'col-' */
        border-bottom: 1px solid #EEE;
        padding: 30px;
    }

    #invoice-top{min-height: 120px;}
    #invoice-mid{min-height: 120px;}
    #invoice-bot{ min-height: 250px;}

    .info{
        display: block;
        float:left;
        margin-left: 20px;
    }
    .title{
        float: right;
    }
    .title p{text-align: right;}
    #project{float: right}
    p#deliverDuration{
        float: right;
        font-size: 15px !important;
    }
    table{
        width: 100%;
        border-collapse: collapse;
    }
    td.tableitem{
        padding: 5px 0 5px 15px;
        border: 1px solid #EEE
    }
    td.item {
        padding: 5px 0 5px 15px;
        border: 1px solid #EEE;
    }
    .tabletitle{
        padding: 5px;
        background: #EEE;
    }
    .service{border: 1px solid #EEE;}
    .item{width: 50%;}
    .itemtext{font-size: .9em;}

    #legalcopy{
        margin-top: 30px;
    }
    form{
        float:right;
        margin-top: 30px;
        text-align: right;
    }
    strong#deliveryTime {
        color: black;
        font-size: 12px;
    }

    .legal{
        width:100%;
    }
</style>
<div style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#f5f8fa;color:#74787e;height:100%;line-height:1.4;margin:0;width:100%!important;word-break:break-word">

    <table width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#f5f8fa;margin:0;padding:0;width:100%"><tbody><tr>
            <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                <table width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:0;padding:0;width:100%">
                    <tbody><tr>
                        <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:25px 0;text-align:center;background-color: #ffc107 !important">
                            <a href="http://eezly-env.eba-k4smuzem.sa-east-1.elasticbeanstalk.com" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#bbbfc3;font-size:19px;font-weight:bold;text-decoration:none" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://eezly-env.eba-k4smuzem.sa-east-1.elasticbeanstalk.com&amp;source=gmail&amp;ust=1608897117682000&amp;usg=AFQjCNGQHshUo80mqTF_EDsvyRdOmFiYaw">
                                <image  src="http://eezly.com/images/logo_default.png" />
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;border-bottom:1px solid #edeff2;border-top:1px solid #edeff2;margin:0;padding:0;width:100%">
                            <table align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;margin:0 auto;padding:0;width:570px">
                                <tbody><tr>
                                    <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:35px">
                                        <h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:left">Bonjour!</h1>
                                        <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Votre commande a été reçue et sera expédiée sous peu. Veuillez vérifier la facture suivante liée à votre commande.</p>
                                        <div id="invoiceholder">

                                            <div id="invoice" class="effect2">

                                                <div id="invoice-top">
                                                    <div class="info">
                                                        <h2>Michael Truong</h2>
                                                        <p> 289-335-6503</br>
                                                            278 Kuvalis Trail
                                                            Brownton, HI 37431
                                                        </p>
                                                    </div><!--End Info-->
                                                    <div class="title">
                                                        <h1>Ordre #1069</h1>
                                                        <p>Statut: Admis</br>
                                                            Date: June 27, 2015
                                                        </p>
                                                    </div><!--End Title-->
                                                </div><!--End InvoiceTop-->



                                                <div id="invoice-mid">
                                                    <div class="info">
                                                        <h2>Resturent Name</h2>
                                                        <p> 555-555-5555JohnDoe@gmail.com</br>
                                                            278 Kuvalis Trail
                                                            Brownton, HI 37431
                                                        </p>
                                                    </div>

                                                    <div id="project">
                                                        <h2>Délai de livraison prévu</h2>
                                                        <p id="deliverDuration">25 Hours </p>
                                                    </div>
                                                </div><!--End Invoice Mid-->

                                                <div id="invoice-bot">

                                                    <div id="table">
                                                        <table>
                                                            <tr class="tabletitle">
                                                                <td class="item"><h2>l' article</h2></td>
                                                                <td class="Hours"><h2>Quantité</h2></td>
                                                                <td class="Rate"><h2>Prix</h2></td>
                                                                <td class="subtotal"><h2>Sub-total</h2></td>
                                                            </tr>

                                                            <tr class="service">
                                                                <td class="tableitem"><p class="itemtext">Communication</p></td>
                                                                <td class="tableitem"><p class="itemtext">5</p></td>
                                                                <td class="tableitem"><p class="itemtext">$75</p></td>
                                                                <td class="tableitem"><p class="itemtext">$375.00</p></td>
                                                            </tr>

                                                            <tr class="service">
                                                                <td class="tableitem"><p class="itemtext">Asset Gathering</p></td>
                                                                <td class="tableitem"><p class="itemtext">3</p></td>
                                                                <td class="tableitem"><p class="itemtext">$75</p></td>
                                                                <td class="tableitem"><p class="itemtext">$225.00</p></td>
                                                            </tr>

                                                            <tr class="service">
                                                                <td class="tableitem"><p class="itemtext">Design Development</p></td>
                                                                <td class="tableitem"><p class="itemtext">5</p></td>
                                                                <td class="tableitem"><p class="itemtext">$75</p></td>
                                                                <td class="tableitem"><p class="itemtext">$375.00</p></td>
                                                            </tr>

                                                            <tr class="service">
                                                                <td class="tableitem"><p class="itemtext">Animation</p></td>
                                                                <td class="tableitem"><p class="itemtext">20</p></td>
                                                                <td class="tableitem"><p class="itemtext">$75</p></td>
                                                                <td class="tableitem"><p class="itemtext">$1,500.00</p></td>
                                                            </tr>

                                                            <tr class="service">
                                                                <td class="tableitem"><p class="itemtext">Animation Revisions</p></td>
                                                                <td class="tableitem"><p class="itemtext">10</p></td>
                                                                <td class="tableitem"><p class="itemtext">$75</p></td>
                                                                <td class="tableitem"><p class="itemtext">$750.00</p></td>
                                                            </tr>

                                                            <tr class="service">
                                                                <td class="tableitem"><p class="itemtext"></p></td>
                                                                <td class="tableitem"><p class="itemtext">l' impôt</p></td>
                                                                <td class="tableitem"><p class="itemtext">13%</p></td>
                                                                <td class="tableitem"><p class="itemtext">$419.25</p></td>
                                                            </tr>


                                                            <tr class="tabletitle">
                                                                <td></td>
                                                                <td></td>
                                                                <td class="Rate"><h2>Le total</h2></td>
                                                                <td class="payment"><h2>$3,644.25</h2></td>
                                                            </tr>

                                                        </table>
                                                    </div><!--End Table-->


                                                    <div id="legalcopy">
                                                        <p class="legal"><strong>Merci d'utiliser Eezly!</strong> Votre commande devrait être livrée dans les  <strong id="deliveryTime">56 hours</strong>.Veuillez contacter les coordonnées fournies pour toute question ou question.</p>
                                                    </div>

                                                </div><!--End InvoiceBot-->
                                            </div><!--End Invoice-->
                                        </div><!-- End Invoice Holder-->
                                        <H3 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">N'hésitez pas à nous contacter pour toutes préoccupations et questions.</H3>
                                        <H1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;font-size:16px;line-height:1.5em;margin-top:0;text-align:left"><span style="color:#74787e;font-size: 14px;">Cordialement,</span><br>Eezly</H1>
                                    </td>
                                </tr>
                                </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Avenir,Helvetica,sans-serif;background-color: #ffc107 !important">
                            <table align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;margin:0 auto;padding:0;text-align:center;width:570px"><tbody><tr>
                                    <td align="center" style="font-family:Avenir,Helvetica,sans-serif;padding:35px">
                                        <p style="font-family:Avenir,Helvetica,sans-serif;line-height:1.5em;margin-top:0;color:#00000 !important;font-size:12px;text-align:center">© 2020 Eezly.Tous les droits sont réservés.</p>
                                    </td>
                                </tr></tbody></table>
                        </td>
                    </tr>
                    </tbody></table>
            </td>
        </tr></tbody></table><div class="yj6qo"></div><div class="adL">
    </div></div>
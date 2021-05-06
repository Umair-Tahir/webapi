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
                            <a href="https://www.eezly.com" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#bbbfc3;font-size:19px;font-weight:bold;text-decoration:none" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://www.eezly.com&amp;source=gmail&amp;ust=1608897117682000&amp;usg=AFQjCNGQHshUo80mqTF_EDsvyRdOmFiYaw">
                                <image  src="https://ally.eezly.com/images/logo_default.png" />
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;border-bottom:1px solid #edeff2;border-top:1px solid #edeff2;margin:0;padding:0;width:100%">
                            <table align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;margin:0 auto;padding:0;width:570px">
                                <tbody><tr>
                                    <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:35px">
                                        <h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:left">Bonjour!</h1>
                                        <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">@if($toRestaurant)Vous avez reçu une nouvelle commande. Veuillez regarder les détails mentionnés ci-dessous. @else
                                                Votre commande a été reçue et sera prête à être livrée sous peu. Veuillez vérifier la facture suivante liée à votre commande. @endif</p>
                                        <div id="invoiceholder">

                                            <div id="invoice" class="effect2">

                                                <div id="invoice-top">
                                                    <div class="info">
                                                        <h2>@if(isset($order->user->name)) {{$order->user->name}}  @endif</h2>
                                                        <p> @if(isset($order->user->phone_number)) {{$order->user->phone_number}}  @endif </br>
                                                            {!! $order->deliveryAddress ? $order->deliveryAddress->address : '' !!}
                                                            {{--@if(isset($order->deliveryAddress->address)) {{$order->deliveryAddress->address}}  @endif--}}
                                                        </p>
                                                    </div><!--End Info-->
                                                    <div class="title">
                                                        <h1>Ordre #@if(isset($order)){{$order->id}} @else Null @endif</h1>
                                                        <p>Le statut: @if(isset($order)){{$order->orderStatus->status}} @else Null @endif</br>
                                                            Date: @if(isset($order)){{$order->orderStatus->created_at->toDateString()}}  @endif
                                                        </p>
                                                    </div><!--End Title-->
                                                </div><!--End InvoiceTop-->



                                                <div id="invoice-mid">
                                                    <div class="info">
                                                        <h2>@if(isset($order->restaurant->name)){{$order->restaurant->name}}  @endif</h2>
                                                        <p> @if(isset($order->restaurant->phone)){{$order->restaurant->phone}} @endif</br>
                                                            @if(isset($order->restaurant->address))  {{$order->restaurant->address}} @endif
                                                        </p>
                                                    </div>

                                                    <div id="project">
                                                        <h2>Délai de livraison prévu</h2>
                                                        <p id="deliverDuration">@if(isset($order->expected_delivery_time) && !is_null($order->expected_delivery_time))  {{$order->expected_delivery_time}} min  @endif </p>
                                                    </div>
                                                </div><!--End Invoice Mid-->

                                                <div id="invoice-bot">

                                                    <div id="table">
                                                        <table>
                                                            <tr class="tabletitle">
                                                                <td class="item"><h2>Item</h2></td>
                                                                <td class="Hours"><h2>Quantité</h2></td>
                                                                <td class="Rate"><h2>Le prix</h2></td>
                                                                <td class="subtotal"><h2>Sub-total</h2></td>
                                                            </tr>
                                                            @if(isset($order))
                                                                @foreach($order->foodOrders as $foodOrder)
                                                                    <tr class="service">
                                                                        <td class="tableitem"><p class="itemtext">{{$foodOrder->food->first()->name}}</p></td>
                                                                        <td class="tableitem"><p class="itemtext">{{$foodOrder->quantity}}</p></td>
                                                                        <td class="tableitem"><p class="itemtext">${{$foodOrder->food->first()->price}}</p></td>
                                                                        <td class="tableitem"><p class="itemtext">${{$foodOrder->price}}</p></td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                            @if(isset($order->delivery_fee) && $order->delivery_fee!=0)
                                                                <tr class="service">
                                                                    <td class="tableitem"><p class="itemtext"></p></td>
                                                                    <td class="tableitem" colspan="2"><p class="itemtext">Frais de livraison</p></td>
                                                                    <td class="tableitem"><p class="itemtext" >${{$order->delivery_fee}}</p></td>
                                                                </tr>
                                                            @endif
                                                            @if($toRestaurant)
                                                                <tr class="service">
                                                                    <td class="tableitem"><p class="itemtext"></p></td>
                                                                    <td class="tableitem" colspan="2"><p class="itemtext">Prix ​​partagé du restaurant</p></td>
                                                                    <td class="tableitem"><p class="itemtext">${{$order->vendor_shared_price}}</p></td>
                                                                </tr>
                                                            @endif
                                                            @if($toRestaurant)
                                                                <tr class="service">
                                                                    <td class="tableitem"><p class="itemtext"></p></td>
                                                                    <td class="tableitem" colspan="2"><p class="itemtext">eezly Frais</p></td>
                                                                    <td class="tableitem"><p class="itemtext">${{$order->eezly_shared_price}}</p></td>
                                                                </tr>
                                                            @endif
                                                            @if(isset($order->tip))
                                                                <tr class="service">
                                                                    <td class="tableitem"><p class="itemtext"></p></td>
                                                                    <td class="tableitem" colspan="2"><p class="itemtext">Pourboire</p></td>
                                                                    <td class="tableitem"><p class="itemtext">${{$order->tip}}</p></td>
                                                                </tr>
                                                            @endif
                                                            <tr class="service">
                                                                <td class="tableitem"><p class="itemtext"></p></td>
                                                                <td class="tableitem" colspan="2"><p class="itemtext">Tax(14.975%)</p></td>
                                                                <td class="tableitem"><p class="itemtext"> @if(isset($order)) ${{$order->tax}}  @endif</p></td>
                                                            </tr>


                                                            <tr class="tabletitle">
                                                                <td></td>
                                                                <td></td>
                                                                <td class="Rate"><h2>Total</h2></td>
                                                                <td class="payment"><h2> @if(isset($order)) ${{$order->grand_total}}  @endif</h2></td>
                                                            </tr>

                                                        </table>
                                                    </div><!--End Table-->


                                                    <div id="legalcopy">
                                                        @if($toRestaurant)
                                                            <p class="legal"><strong>Merci d'utiliser eezly!</strong>  
                                                                La commande devrait être livrée dans les <strong id="deliveryTime">@if(isset($order->expected_delivery_time) && !is_null($order->expected_delivery_time))  {{$order->expected_delivery_time}} mins  @endif</strong>.
                                                                Veuillez contacter le client via le numéro de téléphone fourni si un retard est prévu dans la livraison.</p>
                                                        @else
                                                            <p class="legal"><strong>Merci d'utiliser eezly!</strong>  
                                                                Votre commande devrait être livrée dans les <strong id="deliveryTime">@if(isset($order->expected_delivery_time) && !is_null($order->expected_delivery_time))  {{$order->expected_delivery_time}} mins  @endif</strong>.
                                                                Veuillez contacter le restaurant pour toute question concernant la commande.</p>
                                                        @endif

                                                            @if($toRestaurant)
                                                                @if($order->delivery_type_id=1)
                                                                    <p class="legal"><strong>Merci d'utiliser eezly!</strong>  La commande devrait être récupérée dans les <strong id="deliveryTime">@if(isset($order->expected_delivery_time) && !is_null($order->expected_delivery_time))  {{$order->expected_delivery_time}} prochaines minutes  @endif</strong>.Veuillez contacter le client via le numéro de téléphone fourni si un retard est prévu dans la livraison.</p>

                                                                @else
                                                                    <p class="legal"><strong>Merci d'utiliser eezly!</strong>  La commande devrait être livrée dans les <strong id="deliveryTime">@if(isset($order->expected_delivery_time) && !is_null($order->expected_delivery_time))  {{$order->expected_delivery_time}} prochaines minutes  @endif</strong>.Veuillez contacter le client via le numéro de téléphone fourni si un retard est prévu dans la livraison.</p>
                                                                @endif
                                                            @else
                                                                @if($order->delivery_type_id=1)
                                                                    <p class="legal"><strong>Merci d'utiliser eezly!</strong>  Votre commande sera prête à être récupérée d'ici les <strong id="deliveryTime">@if(isset($order->expected_delivery_time) && !is_null($order->expected_delivery_time))  {{$order->expected_delivery_time}} prochaines minutes  @endif</strong>.Veuillez nous contacter si vous avez des questions concernant votre commande.</p>
                                                                @else
                                                                    <p class="legal"><strong>Merci d'utiliser eezly!</strong>  Votre commande sera livrée dans les  <strong id="deliveryTime">@if(isset($order->expected_delivery_time) && !is_null($order->expected_delivery_time))  {{$order->expected_delivery_time}} prochaines minutes.  @endif</strong>.Veuillez nous contacter si vous avez des questions concernant votre commande.</p>
                                                                @endif
                                                            @endif
                                                    </div>

                                                </div><!--End InvoiceBot-->
                                            </div><!--End Invoice-->
                                        </div><!-- End Invoice Holder-->
                                        <H3 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                            N'hésitez pas à nous contacter pour toutes préoccupations et questions par courriel à <a  href="mailto:hello@eezly.com">hello@eezly.com</a> ou par téléphone au 1-888-693-3959.</H3>
                                        <H1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;font-size:16px;line-height:1.5em;margin-top:0;text-align:left"><span style="color:#74787e;font-size: 14px;">Cordialement,</span><br>eezly</H1>
                                    </td>
                                </tr>
                                </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Avenir,Helvetica,sans-serif;background-color: #ffc107 !important">
                            <table align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;margin:0 auto;padding:0;text-align:center;width:570px"><tbody><tr>
                                    <td align="center" style="font-family:Avenir,Helvetica,sans-serif;padding:35px">
                                        <p style="font-family:Avenir,Helvetica,sans-serif;line-height:1.5em;margin-top:0;color:#000000 !important;font-size:12px;text-align:center">© 2021 eezly. All rights reserved.</p>
                                    </td>
                                </tr></tbody></table>
                        </td>
                    </tr>
                    </tbody></table>
            </td>
        </tr></tbody></table><div class="yj6qo"></div><div class="adL">
    </div></div>
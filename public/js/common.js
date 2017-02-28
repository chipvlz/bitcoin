var URL_PRICE="http://api.kiemtienbtc.com/api/bitcoin";
var sellPrice=0;
var buyPrice=0;
function  numberCurrencyFormat(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
};
//setInterval("getPrices()",1500);
function getPrices(){
	$.ajax({
		  url: URL_PRICE,
		  beforeSend: function( xhr ) {
			xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
			
		  }
	})
	.done(function( data ) {
		var object= $.parseJSON(data);
		var sell=object.VNDSellRate.toString().split(".");
                var buy=object.VNDBuyRate.toString().split(".");
		sellPrice=object.VNDSellRate;
		buyPrice=object.VNDBuyRate;
		$("#sell_price").text(numberCurrencyFormat(sell[0]));
                $("#sellPrice").text(numberCurrencyFormat(sell[0]));
		$("#buy_price").text(numberCurrencyFormat(buy[0]));
		$("#buyPrice").text(numberCurrencyFormat(buy[0]));

            
                $("#weSellPrice").text(numberCurrencyFormat(sell[0]));
		
		$("#weBuyPrice").text(numberCurrencyFormat(buy[0]));
		
	});
	
}

$(document).ready(function(){
	
	/*------- exchange bitcoin -------------*/
if (!window.WebSocket) {
            window.WebSocket = window.MozWebSocket ? window.MozWebSocket : undefined;
consol.log("khsdf");
 }
	
	
	

	$("#sellFormBitCoin").on('keyup',function(){

		var bitcoin=$(this).val();
		var toVND=0;
		if(!isNaN(bitcoin)){
			toVND=bitcoin*buyPrice;
			
		}

               var vndDisplay = numberCurrencyFormat(toVND);

if(vndDisplay.indexOf('.') > -1)
{
  vndDisplay = vndDisplay.split('.')[0];
}

		$("#sellToVND").val(vndDisplay);
		
	});








$("#sellToVND").on('keyup',function(){
		var temp =$(this).val();
                var toVND = temp.replace(/\D/g,'') 

		var fromBitcoin=0;
		if(!isNaN(toVND)){
			fromBitcoin=toVND/buyPrice;
			
		}
		$("#sellFormBitCoin").val(fromBitcoin.toFixed(4));
$(this).val(numberCurrencyFormat(toVND ));
		
	})





	$("#buyFormVND").on('keyup',function(){
		var temp =$(this).val();
                var fromVND = temp.replace(/\D/g,'') 

		var toBitcoin=0;
		if(!isNaN(fromVND)){
			toBitcoin=fromVND/sellPrice;
			
		}
		$("#buyToBitcoin").val(toBitcoin.toFixed(4));
$(this).val(numberCurrencyFormat(fromVND));
		console.log(toBitcoin.toFixed(4));
	})









	$("#buyToBitcoin").on('keyup',function(){

		var bitcoin=$(this).val();
		var fromVND=0;
		if(!isNaN(bitcoin)){
			fromVND=bitcoin*sellPrice;
			
		}

               var vndDisplay = numberCurrencyFormat(fromVND);

if(vndDisplay.indexOf('.') > -1)
{
  vndDisplay = vndDisplay.split('.')[0];
}

		$("#buyFormVND").val(vndDisplay);
		
	});


	/*------- Mmenu -------------*/
	$('nav#menu').mmenu({
		offCanvas: {
		   position  : "right",
		   zposition : "front"
		}
	});
	$(window).scroll(function() {
		var scroll = $(document).scrollTop(),
			HeightFixHeader = $("#head-container").innerHeight();
		if (scroll >= HeightFixHeader) {
			$("#head-container").addClass("head-active");
			$("#content-container").css( "margin-top", HeightFixHeader);
		}else if (scroll < HeightFixHeader + 1) {
			$("#head-container").removeClass("head-active");
			$("#content-container").css( "margin-top", "" );
		}
	});
	
	$("a.link, a.link-purchase").bind("click", function() {
		var HeightFixHeader = $("#head-container").innerHeight();
        var linkTop = $($(this).attr("href")).offset().top - HeightFixHeader;
		console.log(linkTop);
        $("html, body").stop().animate({
            scrollTop: linkTop
        },600);
		return false;
    });
	
});	
new WOW().init();	
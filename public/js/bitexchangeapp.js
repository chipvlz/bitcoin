/**
 * Created by khanhnguyen on 21/4/2016.
 */
// declare a module
(function () {
    'use strict';
    var myAppModule = angular.module('bitExchange', ['formly', 'formlyBootstrap'], function ($interpolateProvider) {
        //$interpolateProvider.startSymbol('<%');
        //$interpolateProvider.endSymbol('%>');
    });
    myAppModule.run(function (formlyConfig) {
        // set templates here
        formlyConfig.setType({
            name: 'currency',
            templateUrl: 'currency.html'
        });

    });
    myAppModule.run(function ($rootScope) {
        $rootScope.sellPrice = 0;
        $rootScope.sellPriceDis = "Loading...";
        $rootScope.buyPrice = 0;
        $rootScope.buyPriceDis = "Loading...";
    });
    myAppModule.constant("CSRF_TOKEN", '<%!! csrf_token() !!%>');
    myAppModule.constant("BASIC_URL", BASIC_URL);
    myAppModule.controller('buyBitCtrl', ['$rootScope', '$scope', 'exchangeService', 'BASIC_URL', function ($rootScope, $scope, exchangeService, BASIC_URL) {
            $scope.qr_code_add = "";
            $scope.address = "";
            var vm = this;
            // funcation assignment
            vm.onSubmit = onSubmit;

            // variable assignment
            vm.author = {// optionally fill in your info below :-)
                name: 'khanhnguyen',
                url: '' // a link to your twitter/github/blog/whatever
            };
            vm.exampleTitle = '';
            vm.env = {
                angularVersion: angular.version.full,
                formlyVersion: ''
            };


            vm.options = {
                formState: {
                    awesomeIsForced: false
                }
            };
            vm.fields = [
                {
                    key: 'bit_amount',
                    type: 'currency',
					ngModelAttrs: {
					  onlyDigits: {
						attribute: 'only-digits'   //directive declaration
					  }
					},
                    templateOptions: {
                        label: 'BẠN CÓ',
                        placeholder: 'Nhập số Bitcoin …',
                        labelCurrency: 'BTC',
                        required: true,
						onlyDigits:'',
                    },
                    watcher: {
                        listener: function (field, newValue, oldValue, $scope, stopWatching) {
                            if (newValue !== oldValue) {

                                cashAmountBIT(newValue);
                            }
                        }
                    }
                },
                {
                    key: 'bank_no',
                    type: 'currency',
                    templateOptions: {
                        label: 'Số tài khoản nhận tiền',
                        placeholder: 'Số tài khoản VCB',
                        labelCurrency: 'VCB',
                        required: true
                    },
                    watcher: {
                        listener: function (field, newValue, oldValue, $scope, stopWatching) {
                            if (newValue !== oldValue && typeof newValue !== 'undefined' && newValue.length === 13) {
                                bindBankInfo(newValue);
                            }
                        }
                    }
                },
                {
                    key: 'account_name',
                    type: 'input',
                    templateOptions: {
                        label: 'Tên tài khoản nhận tiền',
                        disabled: true
                    }
                },
                {
                    key: 'email',
                    type: 'input',
                    templateOptions: {
                        label: 'Email',
                        required: true
                    }
                },
                {
                    key: 'phone',
                    type: 'input',
                    templateOptions: {
                        label: 'Phone',
                        required: true,
                    }
                },
                {
                    key: 'cash_amount',
                    type: 'currency',
                    templateOptions: {
                        label: 'Số tiền nhận bạn được',
                        labelCurrency: 'VND',
                        disabled: true
                    }
                }

            ]
            // function definition
            function onSubmit() {
                alert(JSON.stringify(vm.model), null, 2);
                exchangeService.sell(JSON.stringify(vm.model)).success(function (response) {
                    if (response.success === "true") {
                        $scope.qr_code_add = response.data.qrcode;
                        $scope.address = response.data.address;
                    } else {
                        console.log(response.error);
                    }
                }).error(function (error) {
                     console.log(error);
                    // error callback (optional)
                });
            }
            ;
            function bindBankInfo(value) {
                var data = {
                    "bank_no": value
                };
                exchangeService.bankInfo(JSON.stringify(data)).success(function (response) {
                    //var res=JSON.parse(response);
                    if (response.success === "true") {
                        vm.model.account_name = response.account_name;
                    } else {
                        console.log(response.error);
                    }

                });
            }
            ;
            // handles the callback from the received event
            var handleCallback = function (msg) {
                $rootScope.$apply(function () {
                    var res = JSON.parse(msg.data);

                    $rootScope.sellPrice = res.buy_price;
                    $rootScope.sellPriceDis = exchangeService.numberCurrencyFormat(res.buy_price);
                    $rootScope.buyPrice = res.sel_price;
                    $rootScope.buyPriceDis = exchangeService.numberCurrencyFormat(res.sel_price);
                });
            }

            var source = new EventSource(BASIC_URL + '/get-price');
            source.addEventListener('message', handleCallback, false);
            function cashAmountBIT(value) {

                vm.model.cash_amount = value * $rootScope.buyPrice;
            }
        }]);

    myAppModule.controller('sellBitCtrl', ['$rootScope', 'exchangeService', function ($rootScope, exchangeService) {
            var vm = this;
            vm.onSubmit = onSubmit;

            // variable assignment
            vm.author = {// optionally fill in your info below :-)
                name: 'khanhnguyen',
                url: '' // a link to your twitter/github/blog/whatever
            };
            vm.exampleTitle = '';
            vm.env = {
                angularVersion: angular.version.full,
                formlyVersion: ''
            };


            vm.options = {
                formState: {
                    awesomeIsForced: false
                }
            };
            vm.fields = [
                {
                    key: 'bit_balance',
                    type: 'currency',
                    templateOptions: {
                        label: 'Chúng tôi còn',
                        placeholder: '',
                        labelCurrency: 'BTC',
                        disabled: true
                    }
                },
                {
                    key: 'bit_amount',
                    type: 'currency',
					ngModelAttrs: {
					  onlyDigits: {
						attribute: 'only-digits'   //directive declaration
					  }
					},
                    templateOptions: {
                        label: 'Số lượng cần mua',
                        placeholder: 'Nhập số Bitcoin …',
                        labelCurrency: 'BTC',
                        required: true,
						onlyDigits:'',
                    },
                    watcher: {
                        listener: function (field, newValue, oldValue, $scope, stopWatching) {
                            if (newValue !== oldValue) {
                                vm.model.cash_amount = newValue * $rootScope.sellPrice;
                            }
                        }
                    }

                },
                {
                    key: 'cash_amount',
                    type: 'currency',
                    templateOptions: {
                        label: 'Số tiền cần trả',
                        labelCurrency: 'VND',
                        disabled: true
                    }
                },
                {
                    key: 'bit_address',
                    type: 'input',
                    templateOptions: {
                        label: 'Địa chỉ BTC của bạn',
                        required: true
                    }
                }

            ]
            // function definition
            function onSubmit() {
                alert(JSON.stringify(vm.model), null, 2);
                exchangeService.buy(JSON.stringify(vm.model)).success(function (response) {
                    console.log(response);
                }).error(function (error) {
                    alert("Giao dich bi huy" + error);
                });

            }
        }]);


    myAppModule.factory('exchangeService', ['$http', 'BASIC_URL', function ($http, BASIC_URL) {
            return {
                buy: function (frmData) {
                    //firing ajax request
                    return $http({
                        method: 'POST',
                        //setting url for search ( we have this route in routes.php )
                        url: BASIC_URL + '/buy',
                        //setting object inside param function that will be sent 
                        data: frmData
                    })

                },
                sell: function (frmData) {
                    //firing ajax request
                    return $http({
                        method: 'POST',
                        //setting url for search ( we have this route in routes.php )
                        url: BASIC_URL + '/sell',
                        //setting object inside param function that will be sent 
                        data: frmData
                    })
                },

                bankInfo: function (frmData) {
                    return $http({
                        method: 'POST',
                        //setting url for search ( we have this route in routes.php )
                        url: BASIC_URL + '/bank-info',
                        //setting object inside param function that will be sent 
                        data: frmData
                    })
                },
                numberCurrencyFormat: function (number) {
                    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

            }
        }]);
	myAppModule.directive('onlyDigits', function () {
		return {
		  require: 'ngModel',
		  restrict: 'A',
		  link: function (scope, element, attr, ctrl) {
			function inputValue(val) {
			  
			  if (val) {
				var digits = val.replace(/[^0-9.]/g, '');

				if (digits.split('.').length > 2) {
				  digits = digits.substring(0, digits.length - 1);
				}

				if (digits !== val) {
				  ctrl.$setViewValue(digits);
				  ctrl.$render();
				}
				return parseFloat(digits);
			  }
			  return undefined;
			}            
			ctrl.$parsers.push(inputValue);
		  }
		};
	});	
	
	myAppModule.directive('numbersOnly', function () {
		return {
			
			link: function (scope, element, attr) {
				
				element.bind('change', function () {
					console.log('khanhnguyen');
				})
			}
		};
	});
	
})();


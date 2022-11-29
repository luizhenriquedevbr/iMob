
  $("body").on('click', 'a', function(event){
      if($(this).attr('href') == '#' || $(this).attr('target') == '_blank' || $(this).data('ajax') == false || $(this).hasClass('sf-dump-toggle')){
        return true;
      }

      event.preventDefault();
      redirectTo($(this).attr('href'));
      //$("#content").load($(this).attr('href'));
    });

var toggleSubmitButton = function(form, disabled){
        $(form).find('button').attr('disabled', disabled);
    };



function redirectTo(url){
  $.ajax({
    url: url,
    type: 'GET',
    beforeSend: function(){
      $('.wrapper').loading({
        message: 'Carregando...'
      });
    }
  })
  .done(function(data) {
    $('#content').html(data);
    bootbox.hideAll();
  })
  .fail(function(data) {
    if(data.responseJSON){
      return bootbox.alert(data.responseJSON.message);
    }

    bootbox.alert('Erro ao processar sua requisição, tente novamente!');
  })
  .always(function(){
    $('.wrapper').loading('stop');
  });
}


function validateCPF(objCpf) {
            var cpf, digitsString, digits, a, b, c, d, e, f, g, h, i, j, k, dv1, dv2, soma, resto;
            digitsString = objCpf;
            if (digitsString.length === 11) {
                digits = digitsString.split("");
                a = parseInt(digits[0], 10);
                b = parseInt(digits[1], 10);
                c = parseInt(digits[2], 10);
                d = parseInt(digits[3], 10);
                e = parseInt(digits[4], 10);
                f = parseInt(digits[5], 10);
                g = parseInt(digits[6], 10);
                h = parseInt(digits[7], 10);
                i = parseInt(digits[8], 10);
                j = parseInt(digits[9], 10);
                k = parseInt(digits[10], 10);
                soma = a * 10 + b * 9 + c * 8 + d * 7 + e * 6 + f * 5 + g * 4 + h * 3 + i * 2;
                resto = soma % 11;
                dv1 = (11 - resto < 10 ? 11 - resto : 0);
                soma = a * 11 + b * 10 + c * 9 + d * 8 + e * 7 + f * 6 + g * 5 + h * 4 + i * 3 + dv1 * 2;
                resto = soma % 11;
                dv2 = (11 - resto < 10 ? 11 - resto : 0);
                return dv1 === j && dv2 === k;
            }
            return false;
        }

        var Validator = {
            setError: function(element, message){
                var $divInput = $(element).parent();
                $divInput.addClass('has-error');
                $divInput.find('.form-control-feedback').remove();

                $divInput.append('<div class="form-control-feedback text-danger">' + message +'<br></div>');
            },
            clearFormErrors: function(form){
                $(form)
                    .find('.has-error')
                    .removeClass('has-error')
                    .find('.form-control-feedback')
                    .remove()
                ;
            },
            setFormError: function(errors){
                errors.forEach(function(element){
                    Validator.setError(element.input, element.message);
                });
            }
        };


function ValidaData(data){

        Valida = true;

        day = data.substring(0,2);
        month = data.substring(3,5);
        year = data.substring(6,10);

        if(month > 12 || day > 31){
            Valida = false;
        }

        if( (month==01) || (month==03) || (month==05) || (month==07) || (month==08) || (month==10) || (month==12) )    {//mes com 31 dias
            if( (day < 01) || (day > 31) ){
                Valida = false;
            }
        }else{
            if( (month==04) || (month==06) || (month==09) || (month==11) ){//mes com 30 dias
                if( (day < 01) || (day > 30) ){
                    Valida = false;
                }
            }else{
                if( (month==02) ){//February and leap year
                    if((year % 4 == 0) && ( (year % 100 != 0) || (year % 400 == 0) ) ){
                        if( (day < 01) || (day > 29) ){
                            Valida = false;
                        }
                    }else{
                        if( (day < 01) || (day > 28) ){
                            Valida = false;
                        }
                    }
                }
            }
        }
        return Valida;
    }
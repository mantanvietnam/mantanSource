$(document).ready(function () {
    $('.easy-get').on('click', () => {
        show_easy_numpad();
    });
});

function show_easy_numpad() {
    var easy_numpad = `
        <div class="easy-numpad-frame" id="easy-numpad-frame">
            <div class="easy-numpad-container dialPad compact">
                <div class="easy-numpad-output-container">
                    <input type="text" class="easy-numpad-output number" id="easy-numpad-output" autofocus>
                </div>
                <div class="easy-numpad-number-container dials">
                    <ol>
                        <li class="digits">
                            <p><strong>1</strong></p>
                        </li>
                        <li class="digits">
                            <p><strong>2</strong></p>
                        </li>
                        <li class="digits">
                            <p><strong>3</strong></p>
                        </li>
                        <li class="digits">
                            <p><strong>4</strong></p>
                        </li>
                        <li class="digits">
                            <p><strong>5</strong></p>
                        </li>
                        <li class="digits">
                            <p><strong>6</strong></p>
                        </li>
                        <li class="digits">
                            <p><strong>7</strong></p>
                        </li>
                        <li class="digits">
                            <p><strong>8</strong></p>
                        </li>
                        <li class="digits">
                            <p><strong>9</strong></p>
                        </li>
                        <li class="digits">
                            <p><strong>*</strong></p>
                        </li>
                        <li class="digits">
                            <p><strong>0</strong><sup>+</sup></p>
                        </li>
                        <li class="digits">
                            <p><strong>#</strong></p>
                        </li>
                        <li class="digits">
                            <p><strong><i class="icon-refresh icon-large"></i></strong> <sup>Clear</sup></p>
                        </li>
                        <li class="digits">
                            <p><strong><i class="icon-remove-sign icon-large"></i></strong> <sup>Delete</sup></p>
                        </li>
                        <li class="digits pad-action">
                            <p><strong><i class="icon-phone icon-large"></i></strong> <sup>Call</sup></p>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    `;
    $('body').append(easy_numpad);
}

// $(function(){

            var dials = $(".dials ol li");
            var index;
            var number = $(".number");
            var total;

            dials.click(function(){
                var number_value = $('.number').val();
                index = dials.index(this);
                console.log(index);

                if(index == 0){
                    number.val(number_value + "1");
                    $('.number').focus();

                }else if(index == 1){
                    number.val(number_value + "2");
                    $('.number').focus();
                }else if(index == 2){

                    number.val(number_value + "3");
                    $('.number').focus();

                }else if(index == 3){
                    number.val(number_value + "4");
                    $('.number').focus();

                }else if(index == 4){
                    number.val(number_value + "5");
                    $('.number').focus();
                }else if(index == 5){

                    number.val(number_value + "6");
                    $('.number').focus();

                }else if(index == 6){
                    number.val(number_value + "7");
                    $('.number').focus();

                }else if(index == 7){
                    number.val(number_value + "8");
                    $('.number').focus();
                }else if(index == 8){

                    number.val(number_value + "9");
                    $('.number').focus();

                }else if(index == 9){
                    number.val(number_value + "*");
                    $('.number').focus();

                }else if(index == 10){
                    number.val(number_value + "0");
                    $('.number').focus();
                }else if(index == 11){

                    number.val(number_value + "#");
                    $('.number').focus();

                }else if(index == 12){

                    number.val(" ");
                    $('.number').focus();

                }else if(index == 13){

                    total = number.text();
                    total = total.slice(0,-1);
                    number.empty().append(total);

                    var number_val = $('.number').val();
                    var number_deleted = number_val.slice(0, -1);
                    $('.number').val(number_deleted);
                    $('.number').focus();

                }else if(index == 14){

                }else{ number.append(index+1); }
            });

        // });

// function show_easy_numpad() {
//     var easy_numpad = `
//         <div class="easy-numpad-frame" id="easy-numpad-frame">
//             <div class="easy-numpad-container">
//                 <div class="easy-numpad-output-container">
//                     <input type="text" class="easy-numpad-output" id="easy-numpad-output" autofocus>
//                 </div>
//                 <div class="easy-numpad-number-container">
//                     <table class="">
//                         <tr>
//                             <td><a href="7" onclick="easynum()">7</a></td>
//                             <td><a href="8" onclick="easynum()">8</a></td>
//                             <td><a href="9" onclick="easynum()">9</a></td>
//                             <td class="num_t"><a href="Del" class="del" id="del" onclick="easy_numpad_del()">Xóa</a></td>
//                         </tr>
//                         <tr>
//                             <td><a href="4" onclick="easynum()">4</a></td>
//                             <td><a href="5" onclick="easynum()">5</a></td>
//                             <td><a href="6" onclick="easynum()">6</a></td>
//                             <td class="num_t"><a href="Clear" class="clear" id="clear" onclick="easy_numpad_clear()">Xóa hết</a></td>
//                         </tr>
//                         <tr>
//                             <td><a href="1" onclick="easynum()">1</a></td>
//                             <td><a href="2" onclick="easynum()">2</a></td>
//                             <td><a href="3" onclick="easynum()">3</a></td>
//                             <td class="num_t"><a href="Cancel" class="cancel" id="cancel" onclick="easy_numpad_cancel()">Hủy</a></td>
//                         </tr>
//                         <tr>
//                             <td colspan="3" onclick="easynum()"><a href="0">0</a></td>
                           
//                             <td class="num_t"><a href="Done" class="done" id="done" onclick="easy_numpad_done()">Gọi</a></td>
//                         </tr>
//                     </table>
//                 </div>
//             </div>
//         </div>
//     `;
//     $('body').append(easy_numpad);
// }

// function easy_numpad_close() {
//     $('#easy-numpad-frame').remove();
// }

// function easynum() {
//     event.preventDefault();

//     navigator.vibrate = navigator.vibrate || navigator.webkitVibrate || navigator.mozVibrate || navigator.msVibrate;
//     if (navigator.vibrate) {
//         navigator.vibrate(60);
//     }

//  var easy_numpad_output_before = $('#easy-numpad-output').val();
//     var easy_num_button = $(event.target);
//     var easy_num_value = easy_num_button.text();
//     $('#easy-numpad-output').val(easy_numpad_output_before+easy_num_value);
//     $('#easy-numpad-output').focus();
// }
// function easy_numpad_del() {
//     event.preventDefault();
//     var easy_numpad_output_val = $('#easy-numpad-output').val();
//     var easy_numpad_output_val_deleted = easy_numpad_output_val.slice(0, -1);
//     $('#easy-numpad-output').val(easy_numpad_output_val_deleted);
    
//     $('#easy-numpad-output').focus();
// }
// function easy_numpad_clear() {
//     event.preventDefault();
//     $('#easy-numpad-output').val("");
//     $('#easy-numpad-output').focus();
// }
// function easy_numpad_cancel() {
//     event.preventDefault();
//     $('#easy-numpad-frame').remove();
// }
// function easy_numpad_done() {
//     event.preventDefault();
//     var easy_numpad_output_val = $('#easy-numpad-output').val();
//     $('.easy-put1').val(easy_numpad_output_val);
//     $('#callTo').val(easy_numpad_output_val);
//     easy_numpad_close();
// }


$( "#easy-numpad-output" ).attr("pattern", '[0-9]{8,13}');
$('.easy-get').click(function(){
	$('#easy-numpad-output').focus();
});
$(document).keypress(function (e) {
	if (e.which == 13) {
		easy_numpad_done();
	}
});
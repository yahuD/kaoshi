function dtAlert(options)
{
    if(typeof options === "undefined"){var options = ""};
    var style       = (typeof options.style     === "undefined") ? "default" : options.style;
    var message     = (typeof options.message   === "undefined") ? "" : options.message;
    var title       = (typeof options.title     === "undefined") ? "" : options.title;
    var time        = (typeof options.time      === "undefined") ? 2000 : options.time;
    var size        = (typeof options.size      === "undefined") ? 'md' : options.size;
    var align       = (typeof options.align     === "undefined") ? 'center' : options.align;
    var callback    = (typeof options.callback  === "undefined") ? '' : options.callback;
    var before      = (typeof options.before    === "undefined") ? '' : options.before;

    var html = '<div class="modal modal-'+style+' fade" id="loadAlert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
    html += '        <div class="modal-dialog modal-'+size+'">';
    html += '            <div class="modal-content text-center">';
    html += '                <div class="modal-header">';
    html += '                    <button type="button" class="close closeAlertModal" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fechar</span></button>';
    html += '                    <h2 class="modal-title">'+title+'</h2>';
    html += '                </div>';
    html += '                <div class="modal-body text-'+align+' f16 ">';
    html += '                    <p>'+message+'</p>';
    html += '                </div>';
    html += '            </div>';
    html += '        </div>';
    html += '    </div>';


    eval(before);
    if ( $("#boxAlert").length ){}else{$('body').append('<div id="boxAlert"></div>');}
    $("#boxAlert").html(html);
    $('#loadAlert').show();
    if(time!=0) {setTimeout(function(){$('#loadAlert').hide()},time)};
    $('#loadAlert').on('hidden.bs.modal', function () {eval(callback)});
}
{!! Html::script('/bower/browser-js/browser.min.js') !!}
{!! Html::script('/bower/react/react.min.js') !!}
{!! Html::script('/bower/react/react-dom.min.js') !!}
{!! Html::script('/bower/react/react-dom-server.min.js') !!}
{!! Html::script('/bower/react/react-with-addons.min.js') !!}
{!! Html::script('/bower/jquery/dist/jquery.min.js') !!}
{!! Html::script('/bower/bootstrap/dist/js/bootstrap.min.js') !!}
{!! Html::script('/bower/jquery-ui/jquery-ui.min.js') !!}
{!! Html::script('/bower/jquery-validation/dist/jquery.validate.min.js') !!}
{!! Html::script('/bower/react/react.min.js') !!}
{!! Html::script('/bower/react/react-dom.min.js') !!}
{!! Html::script('/bower/react/react-dom-server.min.js') !!}
{!! Html::script('/bower/react/react-with-addons.min.js') !!}
{!! Html::script('/bower/masonry/dist/masonry.pkgd.min.js') !!}
{!! Html::script('/bower/sweetalert/dist/sweetalert.min.js') !!}
{!! Html::script('/node_modules/socket.io-client/socket.io.js') !!}
{!! Html::script('/js/comment_facebook.js') !!}
{!! Html::script('/js/comment.js') !!}
@if (Auth::check())
    {!! Html::script('js/message.js', ['type' => 'text/babel']) !!}
@endif
{!! Html::script('js/all.js') !!}
{!! Html::script('js/validate.js') !!}

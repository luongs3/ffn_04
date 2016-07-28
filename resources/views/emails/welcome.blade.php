<div class="mail_confirm" >
    <center>
        <table>
            <tr>
                <td align="center" valign="top">
                    <table >
                        <tbody>
                            <tr>
                                <td>
                                    <h1>{{ trans('label.get_start') }}</h1>
                                    <p>{{ trans('message.active_register')}}</p>
                                    {{ URL::to('/register/verify/' . $confirmation_code) }}.<br/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </center>
</div>

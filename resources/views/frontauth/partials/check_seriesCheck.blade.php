 <div class="table-responsive p-0" style="border: 1px solid #dee2e6; border-radius: 12px !important;">
                <table class="table dynamicTable align-items-center mb-0">
                    <thead style="border-bottom: 1px solid #dee2e6;">
                        <tr>
                            <th style="border: 1px solid #dee2e6;"
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alert Type</th>
                            <th style="border: 1px solid #dee2e6;"
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                            <th style="border: 1px solid #dee2e6;"
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">SMS
                            </th>
                            <th style="border: 1px solid #dee2e6;"
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                Mobile App</th>
                        </tr>
                    </thead>
@foreach ($explodeLister as $item)
<input type="hidden" name="lister[{{ $item }}]">
@endforeach
                    <tbody>
                        <tr class="tr1"
                            style="{{ !in_array('1', $explodeLister) ? 'display: none;' : '' }}">
                            <td class="text-start">Subscription Expiring</td>
                            <td><label class="notife-custom-checkbox">
                                    <input class="form-check-input mx-auto" type="checkbox" id="email1"
                                        value="1" name="subscription[email]"
                                        {{ old('subscription.email', @$alertDetails['subscription']['email']) == 1 ? 'checked' : '' }}>
                                    <span></span></label></td>
                            <td><label class="notife-custom-checkbox">
                                    <input class="form-check-input mx-auto" type="checkbox" id="sms1"
                                        value="1" name="subscription[sms]"
                                        {{ old('subscription.sms', @$alertDetails['subscription']['sms']) == 1 ? 'checked' : '' }}>
                                    <span></span></label></td>
                            <td><label class="notife-custom-checkbox">
                                    <input class="form-check-input mx-auto" type="checkbox" id="mobile1"
                                        value="1" name="subscription[mobile]"
                                        {{ old('subscription.mobile', @$alertDetails['subscription']['mobile']) == 1 ? 'checked' : '' }}>
                                    <span></span></label></td>
                        </tr>

                        <tr class="tr1"
                            style="{{  !in_array('1', $explodeLister) ? 'display: none;' : '' }}">
                            <td class="text-start">Payment Received</td>
                            <td><label class="notife-custom-checkbox">
                                    <input class="form-check-input mx-auto" type="checkbox" id="email2"
                                        value="1" name="payment[email]"
                                        {{ old('payment.email', @$alertDetails['payment']['email']) == 1 ? 'checked' : '' }}>
                                    <span></span></label></td>
                            <td><label class="notife-custom-checkbox">
                                    <input class="form-check-input mx-auto" type="checkbox" id="sms2"
                                        value="1" name="payment[sms]"
                                        {{ old('payment.sms', @$alertDetails['payment']['sms']) == 1 ? 'checked' : '' }}>
                                    <span></span></label></td>
                            <td><label class="notife-custom-checkbox">
                                    <input class="form-check-input mx-auto" type="checkbox" id="mobile2"
                                        value="1" name="payment[mobile]"
                                        {{ old('payment.mobile', @$alertDetails['payment']['mobile']) == 1 ? 'checked' : '' }}>
                                    <span></span></label></td>
                        </tr>

                        <tr class="tr2" style="{{ !in_array('2', $explodeLister) ? 'display: none;' : '' }}">
                            <td class="text-start">Auction Ending on Bidding Item</td>
                            <td><label class="notife-custom-checkbox">
                                    <input class="form-check-input mx-auto" type="checkbox" id="email3s"
                                        value="1" name="biddinItem[email]"
                                        {{ old('biddinItem.email', @$alertDetails['biddinItem']['email']) == 1 ? 'checked' : '' }}>
                                    <span></span></label></td>
                            <td><label class="notife-custom-checkbox">
                                    <input class="form-check-input mx-auto" type="checkbox" id="emwail3s"
                                        value="1" name="biddinItem[sms]"
                                        {{ old('biddinItem.sms', @$alertDetails['biddinItem']['sms']) == 1 ? 'checked' : '' }}>
                                    <span></span></label></td>
                            <td><label class="notife-custom-checkbox">
                                    <input class="form-check-input mx-auto" type="checkbox" id="emdail3s"
                                        value="1" name="biddinItem[mobile]"
                                        {{ old('biddinItem.mobile', @$alertDetails['biddinItem']['mobile']) == 1 ? 'checked' : '' }}>
                                    <span></span></label></td>
                        </tr>

                        <tr class="tr2" style="{{ !in_array('2', $explodeLister) ? 'display: none;' : '' }}">
                            <td class="text-start">Listing Matching Saved Search Appears</td>
                            <td><label class="notife-custom-checkbox">
                                    <input class="form-check-input mx-auto" type="checkbox" id="emasil3"
                                        value="1" name="listMatch[email]"
                                        {{ old('listMatch.email', @$alertDetails['listMatch']['email']) == 1 ? 'checked' : '' }}>
                                    <span></span></label></td>
                            <td><label class="notife-custom-checkbox">
                                    <input class="form-check-input mx-auto" type="checkbox" id="ssms3"
                                        value="1" name="listMatch[sms]"
                                        {{ old('listMatch.sms', @$alertDetails['listMatch']['sms']) == 1 ? 'checked' : '' }}>
                                    <span></span></label></td>
                            <td><label class="notife-custom-checkbox">
                                    <input class="form-check-input mx-auto" type="checkbox" id="mosbile3"
                                        value="1" name="listMatch[mobile]"
                                        {{ old('listMatch.mobile', @$alertDetails['listMatch']['mobile']) == 1 ? 'checked' : '' }}>
                                    <span></span></label></td>
                        </tr>

                        <tr class="tr1 tr2"
                            style="{{  !in_array('1', $explodeLister) && !in_array('2', $explodeLister) ? 'display: none;' : '' }}">
                            <td class="text-start">Direct Messaging</td>
                            <td><label class="notife-custom-checkbox">
                                    <input class="form-check-input mx-auto" type="checkbox" id="email3"
                                        value="1" name="auction[email]"
                                        {{ old('auction.email', @$alertDetails['auction']['email']) == 1 ? 'checked' : '' }}>
                                    <span></span></label></td>
                            <td><label class="notife-custom-checkbox">
                                    <input class="form-check-input mx-auto" type="checkbox" id="sms3"
                                        value="1" name="auction[sms]"
                                        {{ old('auction.sms', @$alertDetails['auction']['sms']) == 1 ? 'checked' : '' }}>
                                    <span></span></label></td>
                            <td><label class="notife-custom-checkbox">
                                    <input class="form-check-input mx-auto" type="checkbox" id="mobile3"
                                        value="1" name="auction[mobile]"
                                        {{ old('auction.mobile', @$alertDetails['auction']['mobile']) == 1 ? 'checked' : '' }}>
                                    <span></span></label></td>
                        </tr>

                    </tbody>
                </table>
            </div>
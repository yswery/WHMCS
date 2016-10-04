![Build Status](https://bamboo.coinify.com/plugins/servlet/wittified/build-status/INT-WHMCS)

About
=====
Visit our [API Documentation](https://api.coinify.com) for custom integration.

+ Payment gateway for WHMCS using Coinify version 3 API
+ Version 0.4

System Requirements:
===================
+ Curl PHP Extension
+ JSON Encode

Configuration Instructions:
==========================
    1. Upload files to your WHMCS installation.
    2. Go to your WHMCS administration. Payment Gateways -> "Coinify" click [Activate]
    3. In Coinify Instant Payment Notification (https://coinify.com/merchant/ipn), enter a strong Secret in Coinify Secret. Save changes.
    4. Generate an API Key and API Secret at https://www.coinify.com/merchant/api. (Click the "Generate new API key" button at the bottom of the page)
    5. In module settings "API key" <- Set your Coinify invoice API key
    6. In module settings "API secret" <- Set your Coinify API secret
    7. In module settings "IPN secret" <- Enter your Coinify IPN Secret.
    8. Provide the values from the steps above to the payment gateway.

Changelog:
==========
	Version 0.4
	Fix bug with 'Convert to for processing' and invoices in another currency was 	marked as partially paid.

	Version 0.3 (January 27, 2015)
	Fix bug with database connect file. Now works on version 6.2.0 and 6.1.1.

	Version 0.2 (September 14, 2015)
	Bug fixed with wrong redirect after payment.
	Callback issue resulting in multiple payments fixed

	Version 0.1
	Fixed bug with QR code not being generated in checkout


### Tested with:
* WHMCS V6.3.1
* WHMCS V6.2.0
* WHMCS V6.1.1

#### Disclaimer:

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

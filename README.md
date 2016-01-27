<span class="badges">
![Build Status](https://build.coinify.com/status/INT-WHMCS)
</span>

About
=====
Visit our [API Documentation](https://api.coinify.com) for custom integration.

+ Payment gateway for WHMCS using Coinify version 3 API
+ Version 0.3

System Requirements:
===================
+ Curl PHP Extension
+ JSON Encode

Configuration Instructions:
==========================
    1. Upload files to your WHMCS installation.
    2. Go to your WHMCS administration. Payment Gateways -> "Coinify" click [Activate]
    3. Provide the values from your Coinify account to the payment gateway.

Changelog:
===================
	Version 0.3 (January 27, 2015)
	Fix bug with database connect file. Now works on version 6.2.0 and 6.1.1.

	Version 0.2 (September 14, 2015)
	Bug fixed with wrong redirect after payment.
	Callback issue resulting in multiple payments fixed

	Version 0.1
	Fixed bug with QR code not being generated in checkout


#### Disclaimer:

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

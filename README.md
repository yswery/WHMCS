Copyright (C) 2014 by Coinify

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

About
=====
+ Coinify for WHMCS.
+ Version 0.2
	
System Requirements:
===================
+ Curl PHP Extension
+ JSON Encode
  
Configuration Instructions:
==========================
    1. Upload files to your WHMCS installation.
    2. Go to your WHMCS administration. Payment Gateways -> "Coinify" click [Activate]
    3. In Coinify Instant Payment Notification (https://coinify.com/merchant/ipn) Enter the link to your callback of Coinify WHMCS Payment Module. (http://YOUR_WHMCS_URL/modules/gateways/callback/coinify.php)
    4. Enter a strong Secret in Coinify Secret.
    5. In module settings "API" <- set your Coinify Invoice API Key, which can be generate under API Keys, Invoice.
    6. In module settings "Secret" <- Enter your Coinify Secret.

### Tested with:

+ WHMCS
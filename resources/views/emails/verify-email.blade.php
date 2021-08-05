<p>Hello, <strong>{{ $data['name'] }}</strong></p>
<p>Your Email Verification Link Is <a href="{{ $data['app_url'] }}/verify-email/{{ $data['email_verification_key'] }}">Click Here To Verify Email</a></p>


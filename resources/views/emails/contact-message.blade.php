<h2>Nouveau message depuis le portfolio</h2>
<p><strong>Nom :</strong> {{ $payload['name'] }}</p>
<p><strong>Email :</strong> {{ $payload['email'] }}</p>
<p><strong>Sujet :</strong> {{ $payload['subject'] }}</p>
<p><strong>Message :</strong></p>
<p>{!! nl2br(e($payload['message'])) !!}</p>

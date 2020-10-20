
@component('mail::message')
# Review Request {{ $sub_reviews_update[0] }}
# Review Rating {{ $rating }}

<?php

    // dd($sub_reviews_update);
    for($i=0;$i<count($sub_reviews_update);$i++){
        echo  $sub_reviews_update[$i].'<br>';
    }
?>


I will be grateful if you please act as a reviewer of this manuscript. I thank you for your present and/or future participation. 

Sincerely,

Professor Dr. Md. Golam Farouque
Editor
Bangladesh Journal of Extension Education (BJEE)

@endcomponent
@if(!empty($item->getVideoUrlFromContent()))
    <div class="ratio ratio-4x3">
        <iframe style="border: none; overflow: hidden; width:300px; height:150px;" src="{!! $item->getVideoUrlFromContent() !!}" frameborder="0" scrolling="no" allowfullscreen="allowfullscreen"></iframe>
    </div>
@else
    {{"--"}}
@endif

{{--
https://www.facebook.com/plugins/video.php?height=314&amp;href=https%3A%2F%2Fwww.facebook.com%2Fviconsortium%2Fvideos%2F1401108940430924%2F&amp;show_text=false&amp;width=560&amp;t=0


<iframe style="border: none; overflow: hidden;" src="https://www.facebook.com/plugins/video.php?height=314&amp;href=https%3A%2F%2Fwww.facebook.com%2Fviconsortium%2Fvideos%2F1401108940430924%2F&amp;show_text=false&amp;width=560&amp;t=0" width="560" height="314" frameborder="0" scrolling="no" allowfullscreen="allowfullscreen"></iframe>
--}}

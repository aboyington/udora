<div class="marg20">
    <h4><?php echo lang_check('Comments');?></h4>
    <hr>
    <div class="">
        <div id="disqus_thread"></div>
        <script>
        
        /**
        *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
        *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
        
        var disqus_config = function () {
        this.page.url = '<?php echo $page_current_url; ?>';  // Replace PAGE_URL with your page's canonical URL variable
        this.page.identifier = <?php echo $estate_data_id; ?>; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        };
        
        (function() { // DON'T EDIT BELOW THIS LINE
        var d = document, s = d.createElement('script');
        s.src = 'https://http-udora-io.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
        })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    </div>
</div>

#md-photo-blog

A markdown photo blog

##Rewrite Rules

###nginx

    location /md-photo-blog {
      if (!-e $request_filename) {
        rewrite ^/md-photo-blog(.+)$ /md-photo-blog/webroot/$1 last;
        break;
      }
    }
# imageResizer
PHP class to resize images using php-image-magician 


## Getting Started

Resize all images from a folder 

```
public function resize()
    {
      $url = parse_url('path',PHP_URL_PATH);
      $abs_path = $_SERVER['DOCUMENT_ROOT'] . $url;
      $folders = array(
        $abs_path.'images-folder/',
      );
      foreach ($folders as $folder) {
        ImageResizer::batch_resize($folder);
      }
    }
```

### Prerequisites

php-image-magician

http://phpimagemagician.jarrodoberto.com

thanks to  

http://www.jarrodoberto.com/

## Authors

Luciano Cardoso https://github.com/cardocha


## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details


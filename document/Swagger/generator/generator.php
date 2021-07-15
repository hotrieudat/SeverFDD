<?php
/**
 * Generate sentence for docker-compose.yaml
 */
$fileNames = glob('document/Swagger/*.yaml');
$sentence = '';
$linkLists = '';
$linkFormat = '<li><a href="http://localhost:280%02d/" target="_blank">%s</a></li>';
$formats = [];
$formats[] = '';
$formats[] = '  swagger-ui%02d:';
$formats[] = '    image: swaggerapi/swagger-ui';
$formats[] = '    container_name: "swagger-ui%02d"';
$formats[] = '    ports:';
$formats[] = '      - "280%02d:8080"';
$formats[] = '    volumes:';
$formats[] = '      - ./%s:/usr/share/nginx/html/%s';
$formats[] = '    environment:';
$formats[] = '      API_URL: "%s"';
foreach ($fileNames as $number => $fileName) {
    $fileName = preg_replace('/document\/Swagger\//', '', $fileName);
    $linkLists .= sprintf($linkFormat, $number, $fileName). "\n";
    foreach ($formats as $fn => $format) {
        if ($fn == 1 || $fn == 3 || $fn == 5) {
            $sentence .= sprintf($format, $number) . "\n";
        } else if ($fn == 7) {
            $sentence .= sprintf($format, $fileName, $fileName) . "\n";
        } else if ($fn == 9) {
            $sentence .= sprintf($format, $fileName) . "\n";
        } else {
            $sentence .= $format . "\n";
        }
    }
}
echo $sentence;
$linkHtmlSentence = '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Title</title></head><body><ol>'.$linkLists.'</ol></body></html>';
file_put_contents('document/Swagger/generator/generated/links.html',$linkHtmlSentence);
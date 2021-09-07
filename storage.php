<?php
    require __DIR__ .'/vendor/autoload.php';
    use Google\Cloud\Storage\StorageClient;

    class storage {
        private $projectId;
        private $storage;

        public function __construct(){
            putenv("GOOGLE_APPLICATION_CREDENTIALS=/var/www/html/credentials/folonicmovies-b5d745c5a84a.json");
            $this->projectId = 'folonicmovies';
            $this->storage = new StorageClient([
                'projectId' => $this->projectId
            ]);
        }

        public function createBucket($bucketName){
            $bucket = $this->storage->createBucket($bucketName);
            echo 'Bucket '. $bucket->name(). ' Created';
        }

        public function listBucket(){
            $buckets = $this->storage->buckets();
            foreach ($buckets as $bucket) {
                echo $bucket->name().PHP_EOL;
            }
        }

        public function uploadObject($bucketName, $objectName, $source)
        {
            // $bucketName = 'my-bucket';
            // $objectName = 'my-object';
            // $source = '/path/to/your/file';

            $storage = new StorageClient();
            $file = fopen($source, 'r');
            $bucket = $storage->bucket($bucketName);
            $object = $bucket->upload($file, [
                'name' => $objectName
            ]);
            printf('Uploaded %s to gs://%s/%s' . PHP_EOL, basename($source), $bucketName, $objectName);
        }

        function listObjects($bucketName)
        {
            $storage = new StorageClient();
            $bucket = $storage->bucket($bucketName);
            foreach ($bucket->objects() as $object) {
                printf('Object: %s' . PHP_EOL, $object->name());
            }
        }

        function deleteObject($bucketName, $objectName)
        {
            $storage = new StorageClient();
            $bucket = $storage->bucket($bucketName);
            $object = $bucket->object($objectName);
            $object->delete();
            printf('Deleted gs://%s/%s' . PHP_EOL, $bucketName, $objectName);
        }

        function deleteBucket($bucketName)
        {
            $storage = new StorageClient();
            $bucket = $storage->bucket($bucketName);
            $bucket->delete();
            printf('Bucket deleted: %s' . PHP_EOL, $bucket->name());
        }

        function downloadObject($bucketName, $objectName, $destination)
        {
            $storage = new StorageClient();
            $bucket = $storage->bucket($bucketName);
            $object = $bucket->object($objectName);
            $object->downloadToFile($destination);
            printf('Downloaded gs://%s/%s to %s' . PHP_EOL,
                $bucketName, $objectName, basename($destination));
        }

        function imageUrl($bucket,$object){
            return "https://storage.cloud.google.com/".$bucket."/".$object;
        }

    }


?>
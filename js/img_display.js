<script>
    {/* 看有沒有改變圖片 */}
    document.getElementById('img').addEventListener('change', function (event) {
        const selectedFile = event.target.files[0]; /* 記得要是第0個索引 */
        const currentImage = document.getElementById('currentImageForm');
        if (selectedFile) {
            const reader = new FileReader();
            reader.onload = function (e) {
                currentImage.src = e.target.result;
            };
            reader.readAsDataURL(selectedFile);
        } else {
            // 如果取消選擇檔案就回到一開始的圖片路徑
            const initialImagePath = '/default/path/to/image.jpg';
            currentImage.src = initialImagePath;
        }
    });
</script>

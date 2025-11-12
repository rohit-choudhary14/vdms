<?php
namespace App\Validation;

class FileRules
{
    /**
     * Returns true only when a real file was uploaded (3.x array style).
     */
    public static function isUploaded($value): bool
    {
        if (!is_array($value)) {
            return false;
        }
        $err  = $value['error'] ?? UPLOAD_ERR_NO_FILE;
        $size = (int)($value['size'] ?? 0);
        return $err === UPLOAD_ERR_OK && $size > 0 && !empty($value['tmp_name']);
    }

    /**
     * Fetch reliable MIME using finfo from tmp file; fallback to provided type.
     */
    private static function detectMime(array $value): string
    {
        $tmp = $value['tmp_name'] ?? null;
        if ($tmp && is_file($tmp)) {
            $fi = new \finfo(FILEINFO_MIME_TYPE);
            $detected = $fi->file($tmp);
            if (is_string($detected) && $detected !== '') {
                return $detected;
            }
        }
        return (string)($value['type'] ?? '');
    }

    /**
     * Allow empty (no upload). If uploaded, must be PDF.
     */
    public static function isPdf($value, $context): bool
    {
        if (!is_array($value) || !self::isUploaded($value)) {
            return true; // nothing uploaded => skip rule
        }
        $mime = self::detectMime($value);
        $ext  = strtolower(pathinfo((string)($value['name'] ?? ''), PATHINFO_EXTENSION));
        return ($mime === 'application/pdf') && ($ext === 'pdf');
    }

    /**
     * Allow empty (no upload). If uploaded, must be JPG/JPEG.
     */
    public static function isJpeg($value, $context): bool
    {
        if (!is_array($value) || !self::isUploaded($value)) {
            return true;
        }
        $mime = self::detectMime($value);
        $ext  = strtolower(pathinfo((string)($value['name'] ?? ''), PATHINFO_EXTENSION));
        $info = @getimagesize($value['tmp_name'] ?? '');
        $isImg = $info && ($info[2] === IMAGETYPE_JPEG);

        return $isImg
            && in_array($mime, ['image/jpeg','image/pjpeg'], true)
            && in_array($ext, ['jpg','jpeg'], true);
    }

    /**
     * Max bytes; skips when no file uploaded.
     */
    public static function maxBytes($value, $context, $limit): bool
    {
        if (!is_array($value) || !self::isUploaded($value)) {
            return true;
        }
        return (int)($value['size'] ?? 0) <= (int)$limit;
    }
}

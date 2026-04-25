#!/bin/bash

# =============================================================================
# SCRIPT: fix_psr4_violations.sh
# TUJUAN:  Mengubah semua file .inc.php menjadi .php di app/Domain dan app/Controllers
#          untuk memenuhi standar PSR-4 Composer
# =============================================================================

set -e

echo "=================================================="
echo "PSR-4 Violation Fix Script - Wizdam Editorial 1.0"
echo "=================================================="
echo ""

# Hitung jumlah file .inc.php yang akan diproses
INC_FILES_APP=$(find ./app/Domain ./app/Controllers -name "*.inc.php" 2>/dev/null | wc -l)

if [ "$INC_FILES_APP" -eq 0 ]; then
    echo "✓ Tidak ada file .inc.php di app/Domain atau app/Controllers"
    echo "  File sudah dalam format .php"
else
    echo "✗ Ditemukan $INC_FILES_APP file .inc.php yang perlu diubah"
    echo ""
    
    # Proses rename dari .inc.php ke .php
    echo "Memulai proses rename..."
    find ./app/Domain ./app/Controllers -name "*.inc.php" -print0 | while IFS= read -r -d '' file; do
        newfile="${file%.inc.php}.php"
        mv "$file" "$newfile"
        echo "  ✓ Renamed: $file -> $newfile"
    done
    
    echo ""
    echo "✓ Selesai! Semua file .inc.php telah diubah menjadi .php"
fi

echo ""
echo "=================================================="
echo "LANGKAH SELANJUTNYA:"
echo "1. Jalankan: composer dump-autoload --optimize"
echo "2. Periksa warning yang muncul"
echo "=================================================="

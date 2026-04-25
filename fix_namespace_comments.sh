#!/bin/bash

# =============================================================================
# SCRIPT: fix_namespace_comments.sh
# TUJUAN:  Memperbarui komentar @file di semua file .php agar sesuai dengan
#          nama file baru (tanpa .inc)
# =============================================================================

set -e

echo "=================================================="
echo "Fix Namespace Comments - Wizdam Editorial 1.0"
echo "=================================================="
echo ""

# Cari semua file PHP di app/Domain dan app/Controllers
find ./app/Domain ./app/Controllers -name "*.php" -type f | while read -r file; do
    # Cek apakah ada komentar @file yang menyebutkan .inc.php
    if grep -q "@file.*\.inc\.php" "$file" 2>/dev/null; then
        # Replace .inc.php dengan .php di komentar @file
        sed -i 's/@file \(.*\)\.inc\.php/@file \1.php/g' "$file"
        echo "  ✓ Updated: $file"
    fi
done

echo ""
echo "✓ Selesai! Semua komentar @file telah diperbarui"
echo ""
echo "=================================================="

#!/bin/bash
# =============================================================================
# WIZDAM EDITORIAL 1.0 - PSR-4 COMPLIANCE MIGRATION SCRIPT
# =============================================================================
# Script ini akan:
# 1. Rename folder dari lowercase ke PascalCase
# 2. Rename ekstensi file dari .inc.php ke .php
# 3. Update namespace declarations di dalam file
# =============================================================================

set -e

BASE_DIR="/workspace/app/Helpers"

echo "=========================================="
echo "WIZDAM PSR-4 Migration Script"
echo "=========================================="
echo ""

# -----------------------------------------------------------------------------
# STEP 1: RENAME FOLDERS (lowercase → PascalCase)
# -----------------------------------------------------------------------------
echo "[STEP 1] Renaming folders to PascalCase..."

declare -A FOLDER_MAP=(
    ["services"]="Services"
    ["validator"]="Validators"
    ["security"]="Security"
    ["payment"]="Payment"
    ["checkout"]="Checkout"
    ["invoice"]="Invoice"
    ["redeem"]="Redeem"
    ["cart"]="Cart"
    ["image"]="Image"
    ["form"]="Form"
)

for old_name in "${!FOLDER_MAP[@]}"; do
    new_name="${FOLDER_MAP[$old_name]}"
    
    # Cari semua folder dengan nama lama dan rename
    while IFS= read -r -d '' dir; do
        if [ -d "$dir" ]; then
            parent_dir=$(dirname "$dir")
            new_path="$parent_dir/$new_name"
            
            if [ "$dir" != "$new_path" ] && [ ! -d "$new_path" ]; then
                echo "  ✓ $dir → $new_path"
                mv "$dir" "$new_path"
            elif [ "$dir" = "$new_path" ]; then
                echo "  ⚠ $dir sudah benar"
            else
                echo "  ⚠ $new_path sudah ada, skip"
            fi
        fi
    done < <(find "$BASE_DIR" -type d -name "$old_name" -print0 2>/dev/null)
done

echo ""

# -----------------------------------------------------------------------------
# STEP 2: RENAME FILES (.inc.php → .php)
# -----------------------------------------------------------------------------
echo "[STEP 2] Renaming files from .inc.php to .php..."

find "$BASE_DIR" -type f -name "*.inc.php" | while read -r file; do
    new_file="${file%.inc.php}.php"
    echo "  ✓ $(basename "$file") → $(basename "$new_file")"
    mv "$file" "$new_file"
done

echo ""

# -----------------------------------------------------------------------------
# STEP 3: UPDATE NAMESPACE DECLARATIONS
# -----------------------------------------------------------------------------
echo "[STEP 3] Updating namespace declarations..."

# Mapping namespace lama ke baru
declare -A NS_MAP=(
    ["namespace App\\\\Helpers\\\\services;"]="namespace App\\\\Helpers\\\\Services;"
    ["namespace App\\\\Helpers\\\\service;"]="namespace App\\\\Helpers\\\\Services;"
    ["namespace App\\\\Helpers\\\\validator;"]="namespace App\\\\Helpers\\\\Validators;"
    ["namespace App\\\\Helpers\\\\validators;"]="namespace App\\\\Helpers\\\\Validators;"
    ["namespace App\\\\Helpers\\\\security;"]="namespace App\\\\Helpers\\\\Security;"
    ["namespace App\\\\Helpers\\\\payment;"]="namespace App\\\\Helpers\\\\Payment;"
    ["namespace App\\\\Helpers\\\\checkout;"]="namespace App\\\\Helpers\\\\Checkout;"
    ["namespace App\\\\Helpers\\\\invoice;"]="namespace App\\\\Helpers\\\\Invoice;"
    ["namespace App\\\\Helpers\\\\redeem;"]="namespace App\\\\Helpers\\\\Redeem;"
    ["namespace App\\\\Helpers\\\\cart;"]="namespace App\\\\Helpers\\\\Cart;"
    ["namespace App\\\\Helpers\\\\image;"]="namespace App\\\\Helpers\\\\Image;"
    ["namespace App\\\\Helpers\\\\form;"]="namespace App\\\\Helpers\\\\Form;"
)

find "$BASE_DIR" -type f -name "*.php" | while read -r file; do
    # Baca path relatif untuk menentukan namespace yang benar
    rel_path="${file#$BASE_DIR/}"
    path_parts=($(echo "$rel_path" | tr '/' ' '))
    
    # Bangun namespace dari path
    ns_parts=("App" "Helpers")
    for i in $(seq 0 $((${#path_parts[@]} - 2))); do
        # Capitalize first letter of each folder
        folder="${path_parts[$i]}"
        capitalized="$(tr '[:lower:]' '[:upper:]' <<< ${folder:0:1})${folder:1}"
        ns_parts+=("$capitalized")
    done
    
    expected_ns="namespace $(IFS='\\'; echo "${ns_parts[*]}");"
    
    # Cek apakah file sudah punya namespace declaration
    if grep -q "^namespace " "$file" 2>/dev/null; then
        # Replace namespace yang ada
        sed -i "s/^namespace .*;/$expected_ns/" "$file"
        echo "  ✓ Updated namespace in $rel_path"
    else
        # Tambahkan namespace setelah <?php declare(strict_types=1);
        # atau setelah block komentar pertama
        temp_file=$(mktemp)
        awk -v ns="$expected_ns" '
        /^<\?php/ { print; next }
        /^declare\(strict_types=/ { print; next }
        /^\/\*\*/ && !found { 
            print
            found=1
            next
        }
        /^ \* @file/ && found { 
            print
            next
        }
        /^ \*.*Copyright/ && found { 
            print
            next
        }
        /^ \*\// && found { 
            print
            print ""
            print ns
            print ""
            found=2
            next
        }
        /^class / && found==0 {
            print ""
            print ns
            print ""
            found=2
        }
        /^interface / && found==0 {
            print ""
            print ns
            print ""
            found=2
        }
        { print }
        ' "$file" > "$temp_file" && mv "$temp_file" "$file"
        echo "  ✓ Added namespace in $rel_path"
    fi
done

echo ""
echo "=========================================="
echo "Migration completed!"
echo "=========================================="
echo ""
echo "Next steps:"
echo "1. Review changes in app/Helpers/"
echo "2. Run: composer dump-autoload --optimize"
echo "3. Test your application"

# Hero Slider Improvement - Epic Games Style

## Current Structure
- Background slider dengan 3 images (blur + overlay)
- Left side: Judul + Deskripsi + Stats
- Right side: Robux Calculator

## Proposed Improvements (Epic Games Style)

### 1. **Thumbnail Slider List (WAJIB)**
Tambahkan navigasi thumbnail di bawah atau samping:
- **Position**: Bottom (lebih common) atau Right side
- **Thumbnail Size**: 60-100px dengan border/highlight saat active
- **Animation**: Smooth scroll & highlight indicator
- **Jumlah**: 3-5 thumbnail terlihat, dapat di-scroll/swipe

```html
<div class="hero-thumbnails">
    <div class="thumbnail-item active" onclick="goToSlide(0)">
        <img src="..." alt="">
    </div>
    <div class="thumbnail-item" onclick="goToSlide(1)">
        <img src="..." alt="">
    </div>
</div>
```

---

### 2. **Hero Content - Optimal Layout**

#### Current Layout (Keep):
✅ **Judul** - Besar & Bold (48-64px)
✅ **Deskripsi** - Secondary text (16-18px)
✅ **CTA Button** - "Jelajahi Sekarang" / "Explore Now"

#### Tambahan Saran:
1. **Badge/Tag** (Optional tapi bagus)
   - "🔥 Trending" atau "✨ New" di atas judul
   - Berwarna highlight (cyan/gold)

2. **Stats Row** (Keep tapi improve)
   - ✅ Real-time price update
   - ✅ Successful transactions
   - Tambah: "⭐ Rating: 4.8/5" atau "👥 10K+ Users"

3. **Secondary CTA** (Optional)
   - Button "Lihat Penawaran" atau "Browse Sellers"
   - Warna secondary (outline/ghost)

4. **Tombol Aksi**:
   ```
   Primary: "Jelajahi Sekarang" (Solid button)
   Secondary: "Lihat Lebih Lanjut" (Outline/Ghost button)
   ```

---

### 3. **Visual Improvements**

#### Typography Hierarchy
```
BADGE           10-12px, uppercase, bold
TITLE           52-64px, bold, white
DESCRIPTION     16-18px, regular, rgba(255,255,255,0.8)
STATS           14px, semi-bold, rgba(255,255,255,0.7)
```

#### Color Scheme
- **Primary Text**: White (#FFFFFF)
- **Secondary Text**: rgba(255,255,255,0.8)
- **Accent**: Cyan/Gold highlight
- **Dark Overlay**: rgba(0,0,0,0.6) → 0.7 (sedikit lebih gelap untuk kontras)

#### Animation
- Thumbnail yang active: Scale up + border glow
- Text fade-in saat slide berubah
- Smooth scroll untuk thumbnail list

---

### 4. **Layout Options**

#### Option A: Bottom Thumbnails (RECOMMENDED)
```
┌─────────────────────────────────┐
│                                 │
│      HERO CONTENT               │
│      (Title + Desc + CTA)       │
│                                 │
├─────────────────────────────────┤
│  ⊡  ⊡  ⊡  ⊡  (Thumbnails)     │
└─────────────────────────────────┘
```

#### Option B: Right Side Thumbnails
```
┌──────────────────┬────────┐
│  HERO CONTENT    │   ⊡   │
│                  │   ⊡   │
│                  │   ⊡   │
│                  │ (scroll)
└──────────────────┴────────┘
```

#### Option C: Side Pagination Dots
```
┌─────────────────────────────────┐
│                                 │
│      HERO CONTENT            ●  │
│      (Title + Desc + CTA)    ●  │
│                                 │ ●
├─────────────────────────────────┤
```

---

### 5. **Responsive Behavior**

**Desktop** (1200px+):
- Thumbnails di bottom, horizontal scroll
- Hero content di left, full height
- All text visible

**Tablet** (768-1199px):
- Thumbnails di bottom, 3-4 visible
- Hero content adjusted
- Font size reduced slightly

**Mobile** (< 768px):
- Thumbnails di bottom, 2-3 visible + scroll
- Hero content centered
- Navigation arrows di samping
- Font size responsive

---

### 6. **Recommended UI Components**

1. **Badge Component**
   ```html
   <span class="hero-badge">🔥 Trending</span>
   ```
   CSS: Warna highlight, padding 6-8px, border-radius 20px

2. **Button Group**
   ```html
   <div class="hero-buttons">
       <a href="#" class="btn btn-hero-primary">Jelajahi Sekarang</a>
       <a href="#" class="btn btn-hero-secondary">Lihat Penawaran</a>
   </div>
   ```

3. **Thumbnail Navigation**
   ```html
   <div class="hero-thumbnails-container">
       <div class="thumbnail-scroll">
           <div class="thumbnail-item"></div>
           ...
       </div>
   </div>
   ```

---

### 7. **Code Implementation Order**

1. **Priority 1 (MUST HAVE)**
   - Add thumbnail slider list at bottom
   - Add active state styling
   - Add click/swipe functionality

2. **Priority 2 (SHOULD HAVE)**
   - Add badge above title
   - Improve button styling (primary + secondary)
   - Better stats display

3. **Priority 3 (NICE TO HAVE)**
   - Smooth animations
   - Better responsive design
   - Category/type indicator

---

### 8. **Example Epic Games Style**

Lihat pada screenshot Arc Raiders:
- ✅ Dark overlay dengan gradient
- ✅ Bold white typography
- ✅ Contrasting CTA button
- ✅ Minimal additional UI
- ✅ Focus on imagery + clear messaging

Key: **Simplicity + Impact**

---

## Next Steps

1. **Decision**: Pilih layout (bottom thumbnails recommended)
2. **Implementation**: Add thumbnail navigation component
3. **Styling**: Update CSS untuk visual polish
4. **Testing**: Responsiveness di semua device
5. **Performance**: Lazy load images, optimize animations


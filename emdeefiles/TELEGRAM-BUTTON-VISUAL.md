# Telegram Button Visual Mockup

## 📍 Button Placement in Ticket Status Display

```
┌──────────────────────────────────────────────────────────────────┐
│                     TRACK TICKET TAB                             │
├──────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Enter your ticket ID or email address to check status...       │
│                                                                  │
│  ┌────────────────────────────────┬──────────────────────┐     │
│  │ 🔍 TKT-68F2FB115A82D          │  [Track Status]      │     │
│  └────────────────────────────────┴──────────────────────┘     │
│                                                                  │
│  ╔═══════════════════════════════════════════════════════════╗  │
│  ║  Ticket #TKT-68F2FB115A82D                    [Open] ⚫  ║  │
│  ║  walang internet                                          ║  │
│  ║  ─────────────────────────────────────────────────────    ║  │
│  ║  Created: Oct 18, 2025 10:27 AM                          ║  │
│  ║  Last Updated: Oct 18, 2025 10:27 AM                     ║  │
│  ║                                                            ║  │
│  ║  Priority: [Medium] 🟡                                    ║  │
│  ║  Category: No Internet Connection                         ║  │
│  ║  ─────────────────────────────────────────────────────    ║  │
│  ║  Description                                              ║  │
│  ║  adwadwdawd aw dawdaw test 1                             ║  │
│  ║                                                            ║  │
│  ║  ┌────────────────────────────────────────────────────┐  ║  │
│  ║  │                                                     │  ║  │
│  ║  │     ┌───────────────────────────────────────┐     │  ║  │
│  ║  │     │  📱  Chat with Support on Telegram  │     │  ║  │ ← NEW!
│  ║  │     └───────────────────────────────────────┘     │  ║  │
│  ║  │                                                     │  ║  │
│  ║  │    ⚡ Get instant responses from our support team  │  ║  │
│  ║  │                                                     │  ║  │
│  ║  └────────────────────────────────────────────────────┘  ║  │
│  ╚═══════════════════════════════════════════════════════════╝  │
│                                                                  │
└──────────────────────────────────────────────────────────────────┘
```

---

## 🎨 Button Design Specifications

### Default State
```
╔═══════════════════════════════════════════════════╗
║                                                   ║
║   📱  Chat with Support on Telegram              ║
║                                                   ║
╚═══════════════════════════════════════════════════╝

Background: Linear Gradient (#0088cc → #00bcd4)
Text Color: White (#FFFFFF)
Border Radius: 50px (pill shape)
Shadow: 0 4px 15px rgba(0, 136, 204, 0.3)
Icon: Telegram (bi-telegram) at 1.3rem
```

### Hover State
```
╔═══════════════════════════════════════════════════╗
║     ↑ (lifts up 2px)                             ║
║   📱  Chat with Support on Telegram              ║
║                                                   ║
╚═══════════════════════════════════════════════════╝
       ╰────────── stronger shadow ──────────╯

Background: Darker Gradient (#006699 → #0099cc)
Transform: translateY(-2px)
Shadow: 0 6px 20px rgba(0, 136, 204, 0.5)
Transition: 0.3s ease
```

---

## 🎯 Button Anatomy

```
┌─────────────────────────────────────────────────────────┐
│                                                         │
│  [Icon]    [Button Text]                               │
│   📱       Chat with Support on Telegram               │
│                                                         │
│  ┌──────┐  ┌────────────────────────────┐             │
│  │      │  │                            │             │
│  │ 1.3  │  │  Font: Poppins/Inter       │             │
│  │ rem  │  │  Weight: 600 (Semi-bold)   │             │
│  │      │  │  Color: White              │             │
│  └──────┘  └────────────────────────────┘             │
│                                                         │
└─────────────────────────────────────────────────────────┘
│←────────── Padding: 3rem (48px) ──────────→│
```

---

## 📐 Responsive Breakpoints

### Desktop (≥992px)
```
┌────────────────────────────────────────────────┐
│                                                │
│  ┌──────────────────────────────────────────┐ │
│  │  📱 Chat with Support on Telegram       │ │
│  └──────────────────────────────────────────┘ │
│                                                │
│  Full width with large padding                │
└────────────────────────────────────────────────┘
```

### Tablet (768px - 991px)
```
┌───────────────────────────────────────┐
│                                       │
│  ┌─────────────────────────────────┐ │
│  │ 📱 Chat with Support on Telegram│ │
│  └─────────────────────────────────┘ │
│                                       │
│  Slightly reduced padding             │
└───────────────────────────────────────┘
```

### Mobile (<768px)
```
┌─────────────────────────────┐
│                             │
│  ┌───────────────────────┐ │
│  │ 📱 Chat on Telegram  │ │
│  └───────────────────────┘ │
│                             │
│  Compact but tap-friendly   │
└─────────────────────────────┘
```

---

## 🌈 Color Palette

### Primary Colors
```
Default Gradient:
┌─────────────────────────────────┐
│  #0088cc → #00bcd4             │
│  ████████████████████████████   │
│  Telegram Blue → Cyan          │
└─────────────────────────────────┘

Hover Gradient:
┌─────────────────────────────────┐
│  #006699 → #0099cc             │
│  ████████████████████████████   │
│  Dark Blue → Medium Cyan       │
└─────────────────────────────────┘
```

### Shadow Colors
```
Default: rgba(0, 136, 204, 0.3)
Hover:   rgba(0, 136, 204, 0.5)
Active:  rgba(0, 136, 204, 0.4)
```

---

## 💬 Complete Visual Flow

```
┌────────────────────────────────────────────────────────────┐
│ STEP 1: User Tracks Ticket                                │
├────────────────────────────────────────────────────────────┤
│                                                            │
│  [Track Ticket] tab is active                             │
│  User enters: TKT-68F2FB115A82D                           │
│  Clicks: [Track Status]                                    │
│                                                            │
└────────────────────────────────────────────────────────────┘
                         ↓
┌────────────────────────────────────────────────────────────┐
│ STEP 2: Ticket Status Displays                            │
├────────────────────────────────────────────────────────────┤
│                                                            │
│  ╔══════════════════════════════════════════════════════╗ │
│  ║  Ticket Details                                      ║ │
│  ║  • Ticket ID: TKT-68F2FB115A82D                      ║ │
│  ║  • Status: Open                                      ║ │
│  ║  • Priority: Medium                                  ║ │
│  ║  • Description: walang internet                      ║ │
│  ╚══════════════════════════════════════════════════════╝ │
│                                                            │
└────────────────────────────────────────────────────────────┘
                         ↓
┌────────────────────────────────────────────────────────────┐
│ STEP 3: Telegram Button Appears ⭐ NEW!                   │
├────────────────────────────────────────────────────────────┤
│                                                            │
│           ┌────────────────────────────────┐              │
│           │ 📱 Chat with Support on        │              │
│           │    Telegram                    │              │
│           └────────────────────────────────┘              │
│                                                            │
│     ⚡ Get instant responses from our support team        │
│                                                            │
└────────────────────────────────────────────────────────────┘
                         ↓
┌────────────────────────────────────────────────────────────┐
│ STEP 4: User Clicks Button                                │
├────────────────────────────────────────────────────────────┤
│                                                            │
│  • Opens new tab/window                                    │
│  • Redirects to: https://t.me/CampaSupport_bot           │
│  • User gets instant support via Telegram! 🎉             │
│                                                            │
└────────────────────────────────────────────────────────────┘
```

---

## 🎭 Animation Sequence

```
Timeline: 0.3 seconds total

0.0s  │  Default State
      │  ████████████████████  ← Button at normal position
      │  Shadow: soft
      │
      │
0.1s  │  Hover Detected
      │  ████████████████████  ← Button starts lifting
      │  Shadow: grows
      │
      │
0.2s  │  Hover Animation
      │   ███████████████████  ← Button 2px up
      │  Shadow: stronger
      │
      │
0.3s  │  Hover Complete
      │   ███████████████████  ← Darker gradient
      │   ═══════════════════  ← Maximum shadow
      │
      │
      │  [User Clicks]
      │
0.0s  │  Active State
      │  ████████████████████  ← Back to position
      │  Shadow: reduced
      │  Opens Telegram! 🎉
```

---

## 📊 Size Comparison

```
Button Sizes Across Devices:

┌──────────────────────────────────────────────┐
│ Desktop (1920px)                             │
│ ┌──────────────────────────────────────────┐│
│ │   📱 Chat with Support on Telegram      ││
│ └──────────────────────────────────────────┘│
│ Padding: 48px horizontal                     │
└──────────────────────────────────────────────┘

┌────────────────────────────────────────┐
│ Tablet (768px)                         │
│ ┌────────────────────────────────────┐ │
│ │ 📱 Chat with Support on Telegram  │ │
│ └────────────────────────────────────┘ │
│ Padding: 36px horizontal               │
└────────────────────────────────────────┘

┌────────────────────────────┐
│ Mobile (375px)             │
│ ┌────────────────────────┐ │
│ │📱 Chat on Telegram    │ │
│ └────────────────────────┘ │
│ Padding: 24px horizontal   │
└────────────────────────────┘
```

---

## 🎯 Clickable Area

```
Touch Target (Mobile):

┌────────────────────────────────────┐
│ ┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓ │
│ ┃                                ┃ │
│ ┃                                ┃ │ ← Minimum 44px height
│ ┃  📱 Chat with Support         ┃ │   (Apple guidelines)
│ ┃                                ┃ │
│ ┃                                ┃ │
│ ┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛ │
│        Entire area tappable        │
└────────────────────────────────────┘
```

---

## 🔍 Before vs After Comparison

### BEFORE (Without Button)
```
┌───────────────────────────────────┐
│ Ticket Status Display             │
├───────────────────────────────────┤
│ • Ticket ID: TKT-XXX             │
│ • Status: Open                    │
│ • Priority: Medium                │
│ • Description: Issue details      │
│                                   │
│ [End of ticket display]           │
│                                   │
│ ❌ No direct way to chat          │
│ ❌ User must find contact info    │
│ ❌ Extra steps required            │
└───────────────────────────────────┘
```

### AFTER (With Button)
```
┌───────────────────────────────────┐
│ Ticket Status Display             │
├───────────────────────────────────┤
│ • Ticket ID: TKT-XXX             │
│ • Status: Open                    │
│ • Priority: Medium                │
│ • Description: Issue details      │
│                                   │
│ ┌───────────────────────────────┐│
│ │ 📱 Chat with Support on      ││
│ │    Telegram                   ││
│ └───────────────────────────────┘│
│                                   │
│ ✅ Instant access to support      │
│ ✅ One-click chat                 │
│ ✅ Clear call-to-action           │
└───────────────────────────────────┘
```

---

## 📱 Mobile Interaction Flow

```
Mobile Device View:

┌─────────────────────────┐
│ 📱 Phone Screen         │
│                         │
│ [Ticket Details]        │
│                         │
│ ┌─────────────────────┐ │
│ │ 📱 Chat on Telegram│ │ ← User taps here
│ └─────────────────────┘ │
│         ↓ tap           │
│                         │
│ [Opens Telegram App]    │
│                         │
│ ┌─────────────────────┐ │
│ │                     │ │
│ │  CampaSupport_bot   │ │
│ │                     │ │
│ │  Hi! How can I      │ │
│ │  help you today?    │ │
│ │                     │ │
│ │  [Type message...]  │ │
│ │                     │ │
│ └─────────────────────┘ │
│                         │
│ ✅ Instant chat started │
└─────────────────────────┘
```

---

## 🎨 CSS Visual Representation

```css
/* Button Layers */

Layer 1: Base Shape
┌──────────────────────────┐
│   Rounded pill shape     │
│   Border-radius: 50px    │
└──────────────────────────┘

Layer 2: Gradient Background
┌──────────────────────────┐
│ ░░░░░░░░░░░░░░░░░░░░░░░ │
│ ▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒ │ ← #0088cc to #00bcd4
│ ▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓ │
└──────────────────────────┘

Layer 3: Text & Icon
┌──────────────────────────┐
│  📱 Chat with Support   │ ← White text, bold
└──────────────────────────┘

Layer 4: Shadow
┌──────────────────────────┐
│                          │
│      [Button above]      │
│                          │
│  ╰─────────────────────╯ │ ← Soft shadow
└──────────────────────────┘
```

---

## ✨ Final Visual Summary

```
COMPLETE BUTTON VISUALIZATION:

┌────────────────────────────────────────────────────┐
│                                                    │
│  Ticket Status Card                               │
│  ┌──────────────────────────────────────────────┐ │
│  │ Ticket #TKT-68F2FB115A82D          [Open]    │ │
│  │ walang internet                               │ │
│  │ ───────────────────────────────────────────   │ │
│  │ Created: Oct 18, 2025 10:27 AM               │ │
│  │ Priority: Medium | Category: No Connection   │ │
│  │ ───────────────────────────────────────────   │ │
│  │ Description: adwadwdawd aw dawdaw test 1     │ │
│  │                                               │ │
│  │        ┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓       │ │
│  │        ┃                             ┃       │ │
│  │        ┃  📱 Chat with Support on   ┃       │ │
│  │        ┃     Telegram                ┃       │ │
│  │        ┃                             ┃       │ │
│  │        ┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛       │ │
│  │              └─ Gradient Blue ─┘             │ │
│  │                                               │ │
│  │   ⚡ Get instant responses from our support  │ │
│  │                                               │ │
│  └──────────────────────────────────────────────┘ │
│                                                    │
└────────────────────────────────────────────────────┘

KEY FEATURES:
• Telegram blue gradient background
• Large, pill-shaped button
• Telegram icon (📱) on the left
• White, bold text
• Hover lift effect (+2px up)
• Opens in new tab → t.me/CampaSupport_bot
• Fully responsive on all devices
```

---

**Status:** ✅ Implemented  
**Location:** Below ticket description  
**Link:** https://t.me/CampaSupport_bot  
**Last Updated:** January 2025
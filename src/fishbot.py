import cmocean

BACKGROUND_COLOR = [22, 24, 25]
STOP_COUNT = 20
ALPHA = 0.6

cmap = cmocean.cm.cmap_d["phase"]
print("@keyframes fishbot {")
for stop in range(STOP_COUNT + 1):
    color = [
        round(foreground * 255) * ALPHA + background * (1 - ALPHA)
        for foreground, background in zip(cmap(stop / STOP_COUNT)[:3], BACKGROUND_COLOR)
    ]
    print(f"  {int(stop / STOP_COUNT * 100)}% {{")
    print(f"    border-bottom-color: rgb({color[0]}, {color[1]}, {color[2]});")
    print("  }")
print("}")
